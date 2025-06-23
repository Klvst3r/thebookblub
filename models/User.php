<?php

namespace app\models;

use yii\db\ActiveRecord;

use Exception;

//class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
class User extends ActiveRecord implements \yii\web\IdentityInterface
{

    public $password_repeat;
    public $email;
     
    //public $bio;

    /*
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    */

    /*
    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];
    */
    public static function tableName()
    {
        return 'users'; // Aquí especificas el nombre correcto de la tabla
    }


    public function attributeLabels()
    {
        return [
            'username' => 'Usuario',
            'password' => 'Password',
            'password_repeat' => 'Repetir password',
            'bio' => 'Biografía',
        ];
    }


    public function attributeHints()
    {
        return [
            'username' => 'debera ser unico en el sistema',
            'password' => 'Clave con 8 caracterirs como minimo',
            'password_repeat' => 'Tiene que ser igual al anterior',
            'bio' => 'Breve resera bibliografica',
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        $user = self::findOne($id);
        if(empty($user)){
            return null;
        }
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        */
         $user = self::findOne(['token' => $token]);

         if(empty($user)){
            return null;
         }
         return $user;
    }
   

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */

    public static function findByUsername($username)
    {
        /*foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;*/
        $user = self::find()->where(['username' => $username])->one();
        if(empty($user)){
            return null;
        }
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        //return $this->id;
        return $this->user_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        //return $this->authKey;
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //return $this->password === $password;
        return $this->password === $this->ofuscatePassword($password);
    }

    /*
    public function ofuscatePassword($password) {

        if(empty(getenv('salt'))){
            throw new Exception('no salt');
        }
        return md5(sprintf('%s-%s-%s', $password, $this->username, getenv('salt')));
    }
        */
 
    //modificamos esta funcion para el metodo ofuscatePassword
    public function ofuscatePassword($password) {
        $salt = getenv('salt') ?: 'default_salt';
        return md5(sprintf('%s-%s-%s', $password, $this->username, $salt));
    }

    public function beforeSave($insert){
        if($insert == true){    //significa que esta haciendo la primera vez un usuario
            $this->password = $this->ofuscatePassword($this->password);
        }
         return parent::beforeSave($insert);
    }

    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat'], 'required'],
            [['username'], 'filter', 'filter' => function($v){
                $v = ltrim(rtrim($v));
                $v = strtolower($v);
                return $v;
            }],
            [['username'], 'unique'],
            [['username'], 'string', 'length' => [4-100] ],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Las contraseñas no coinciden.'],
            [['bio'], 'default'],
            [['email'], 'email'],
            
            // Se puede añadir otras reglas que ya se tengan
        ];
    }

    public function hasBook($book_id): bool
    {
        return UserBook::find()
            ->where(['user_id' => $this->id, 'book_id' => $book_id])
            ->exists();
    }

    //  public function actionView($id)
    // {
    //     $book = Book::findOne($id);
    //     $userHasBook = Yii::$app->user->identity->hasBook($id);
        
    //     return $this->render('view.tpl', [
    //         'book' => $book,
    //         'userHasBook' => $userHasBook,
    //     ]);
    // }


    //Traemos el contador de los votos por usuarios
   public function getVotes()
    {
        return $this->hasMany(BookScore::class, ['user_id' => 'user_id']);
    }


    //ahora necesito el promedio y el numero de elementos de los votos

    public function getVotesCount(){

        return count($this->votes);
    }

    public function getVotesAvg(){
        $i = 0;
        $sum = 0;
        foreach($this->votes as $vote){
            $i++;
            $sum+= $vote->score;
            if ($i == 0){
                return "Sin votos";
            }
            return sprintf("%0.2f", $sum/$i);
        }
    }
}
