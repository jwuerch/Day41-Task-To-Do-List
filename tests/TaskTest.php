<?php
    require_once 'src/Task.php';

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TaskTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown() {
            Task::deleteAll();
        }
        function test_save() {
            //Arrange;
            $description = "Wash the dog";
            $test_task = new Task($description);

            //Act;
            $test_task->save();

            //Assert;
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);

        }

        function test_getAll() {

            //Arrage;
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $test_task = new Task($description);
            $test_task->save();
            $test_task2 = new Task($description2);
            $test_task2->save();

            //Act;
            $result = Task::getAll();

            //Assert;
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function test_getID() {

            //Arrange;
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);

            //Act;
            $result = $test_task->getId();

            //Assert;
            $this->assertEquals(1, $result);
        }
    }

 ?>
