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
            $id = 1;
            $due_date = '1989-03-07';
            $test_task = new Task($description, $id, $due_date);

            //Act;
            $test_task->save();

            //Assert;
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);

        }

        function test_getAll() {

            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $due_date = '1989-03-07';
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $description2 = "Water the lawn";
            $id2 = 2;
            $test_task2 = new Task($description2, $id2, $due_date);
            $test_task2->save();

            //Act;
            $result = Task::getAll();

            //Assert;
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function test_getId()
        {
          //arrange
          $description = "Wash the dog";
          $id = 1;
          $due_date = "2016-03-14";
          $test_task = new Task($description, $id, $due_date);
          $test_task->save();

          //Act
          $result = $test_task->getId();

          //assert
          $this->assertEquals(true, is_numeric($result));
        }

        function test_deleteAll() {
          //Arrange;
          $description = "Wash the dog";
          $id = 1;
          $due_date = '1989-03-07';
          $test_task = new Task($description, $id, $due_date);
          $test_task->save();

          $description2 = "Water the lawn";
          $id2 = 2;
          $test_task2 = new Task ($description2, $id2, $due_date);
          $test_task2->save();

          //Act;
          Task::deleteAll();

          //Assert;
          $result = Task::getAll();
          $this->assertEquals([], $result);
        }

        function test_find() {
          //Arrange;
          $description = "Wash the dog";
          $id = 1;
          $due_date = "2015-03-25";
          $test_task = new Task($description, $id, $due_date);
          $test_task->save();

          $description2 = "Water the lawn";
          $id2 = 2;
          $due_date = "2015-03-25";
          $test_task2 = new Task($description2, $id2, $due_date);
          $test_task->save();

          //Act;
          $result = Task::find($test_task->getId());

          //Assert
          $this->assertEquals($test_task, $result);
        }

        function test_get_date() {
          //arrange
          $description = "Put tools away";
          $id = 1;
          $due_date = "2016-03-25";
          $test_task = new Task($description, $id, $due_date);
          $test_task->save();

          //act
          $result = $test_task->getDueDate();

          //assert
          $this->assertEquals($due_date, $result);

        }

        function test_sort_by_date() {
          //arrange
          $description = "Put tools away";
          $id = 1;
          $due_date = "2016-03-25";
          $test_task = new Task($description, $id, $due_date);
          $test_task->save();

          $description2 = "Sweep Floor";
          $id2 = 2;
          $due_date2 = "2016-01-25";
          $test_task2 = new Task($description2, $id2, $due_date2);
          $test_task2->save();

          //act
          $result = Task::getAll();
          //assert
          $this->assertEquals([$test_task2, $test_task], $result);
        }
    }

 ?>
