<?php
// PHP-класс для работы с базой данных
class DB
{
    protected static $dbHandle; // Объект подключения (PDO)

    private $dbHost = 'localhost'; // Адрес сервера БД
    private $dbUser = 'msgboard'; // Логин для доступа к серверу
    private $dbPassword = 'YOUR_PASSWORD'; // Пароль для доступа к серверу
    private $dbName = 'msgboard'; // Название базы данных

// Процедура подколючения к серверу
    private function connect()
    {
        if (self::$dbHandle instanceof PDO) {
            return; // Если подключение уже установлено, выходим из этой процедуры
        }

/* Опции (атрибуты) для подключения к базе данных:
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC - получать результат из БД в виде именованного массива (ключ - значение)
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION - в случае ошибки бросаем исключение */
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

// Попытка подключения к серверу БД
        try {
// Создаём подключение - передаём адрес сервера, название БД, пользователя, пароль и опции
            self::$dbHandle = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName;charset=utf8", $this->dbUser, $this->dbPassword, $options);
        } catch (PDOException $e) {
            echo '<span class="dbError">Ошибка при подключении: ' . $e->getMessage() . '</span>';
            die();
        }
    }

// Процедура подготовки SQL-запроса - на вход принимаем строку с запросом
    protected function prepare($sql)
    {
        $this->connect(); // Подключаемся к серверу

        return self::$dbHandle->prepare($sql); // Возвращаем подготовленный запрос
    }

// Процедура выборки из базы данных - на вход принимаем строку с запросом и массив с названями полей
    public function select($sql, $data = [])
    {
        $preparedStatement = $this->prepare($sql); // Подготавливаем запрос
        try {
            $preparedStatement->execute($data); // Выполняем запрос с подстановкой полей
        } catch (PDOException $e) {
            echo '<span class="dbError">Ошибка при выполнении SELECT: ' . $e->getMessage() . '</span>';
            die();
        }

        return $preparedStatement->fetchAll(); // Возвращаем именованный массив "поле - значение"
    }

// Процедура вставки в базу данных - на вход принимаем строку с запросом и какие-либо параметры
    public function insert($sql, $data)
    {
        $preparedStatement = $this->prepare($sql); // Подготавливаем запрос
        try {
            $preparedStatement->execute($data); // Выполняем запрос с подстановкой параметров
        } catch (PDOException $e) {
            echo '<span class="dbError">Ошибка при выполнении INSERT: ' . $e->getMessage() . '</span>';
            die();
        }
        return self::$dbHandle->lastInsertId(); // Возвращаем ID последнего вставленного элемента
    }

// Процедура выполнения произвольного запроса к БД - на вход принимаем строку с запросом и какие-либо параметры
    public function query($sql, $data)
    {
        $preparedStatement = $this->prepare($sql); // Подготавливаем запрос
        try {
            $execResult = $preparedStatement->execute($data);
        } catch (PDOException $e) {
            echo '<span class="dbError">Ошибка при выполнении запроса: ' . $e->getMessage() . '</span>';
            die();
        }

// Выполняем запрос с подстановкой параметров, возвращаем результат выполения (истина - запрос выполнен, ложь - запрос не выполнен или выполнен с ошибкой)
        return $execResult;
    }
}