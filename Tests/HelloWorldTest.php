<?php

class HelloWorldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PDO
     */
    private $pdo;

    public function setUp()
    {
        $strServer = "localhost";
        $strServerPort = "21";
        $strServerUsername = "root";
        $strServerPassword = "";
        
        //connect to server
        $resConnection = ssh2_connect($strServer, $strServerPort);
        
        if(ssh2_auth_password($resConnection, $strServerUsername, $strServerPassword)){
        	//Initialize SFTP subsystem
        	$resSFTP = ssh2_sftp($resConnection);
        	
        	//
        	//Send/Download file here
        	//
        }else{
        	echo "Unable to authenticate on server";
        }


        $this->pdo = new PDO($GLOBALS['db_dsn'], $GLOBALS['db_username'], $GLOBALS['db_password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->query("CREATE TABLE hello (what VARCHAR(50) NOT NULL)");
    }

    public function tearDown()
    {
        $this->pdo->query("DROP TABLE hello");
    }

    public function testHelloWorld()
    {
        $helloWorld = new HelloWorld($this->pdo);

        $this->assertEquals('Hello World', $helloWorld->hello());
    }

    public function testHello()
    {
        $helloWorld = new HelloWorld($this->pdo);

        $this->assertEquals('Hello Bar', $helloWorld->hello('Bar'));
    }

    public function testWhat()
    {
        $helloWorld = new HelloWorld($this->pdo);

        $this->assertFalse($helloWorld->what());

        $helloWorld->hello('Bar');

        $this->assertEquals('Bar', $helloWorld->what());
    }
}

