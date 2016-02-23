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
            Category::deleteAll();

        }

        function test_save() {
            //Arrange;
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $due_date = '1989-03-07 00:00:00';
            $test_task = new Task($description, $id, $category_id, $due_date);

            //Act;
            $test_task->save();

            //Assert;
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);

        }

        function test_getAll() {

            //Arrange
            $name = "Home stuff";
            $id = null;
            $due_date = "2015-03-16 00:00:00";
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $category_id = $test_category->getId();
            $test_task = new Task($description, $id, $category_id, $due_date);
            $test_task->save();

            $description2 = "Water the lawn";
            $test_task2 = new Task($description2, $id, $category_id, $due_date);
            $test_task2->save();

            //Act;
            $result = Task::getAll();

            //Assert;
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function test_getId()
        {
          //arrange
          $name = "Home stuff";
          $id = null;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "Wash the dog";
          $due_date = "2016-03-14 00:00:00";
          $category_id = $test_category->getId();
          $test_task = new Task($description, $id, $category_id, $due_date);
          $test_task->save();

          //Act
          $result = $test_task->getId();

          //assert
          $this->assertEquals(true, is_numeric($result));
        }

        function test_getCategoryId()
        {
          //arrange
          $name = "Home stuff";
          $id = null;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "Wash the dog";
          $due_date = '1989-03-07 00:00:00';
          $category_id = $test_category->getId();
          $test_task = new Task($description, $id, $category_id, $due_date);
          $test_task->save();

          //act
          $result = $test_task->getCategoryId();

          $this->assertEquals(true, is_numeric($result));
        }

        function test_deleteAll() {
          //Arrange;
          $name = "Home Stuff";
          $id = null;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "Wash the dog";
          $due_date = '1989-03-07 00:00:00';
          $category_id = $test_category->getId();
          $test_task = new Task($description, $id, $category_id, $due_date);
          $test_task->save();

          $description2 = "Water the lawn";
          $test_task2 = new Task ($description2, $id, $category_id, $due_date);
          $test_task2->save();

          //Act;
          Task::deleteAll();

          //Assert;
          $result = Task::getAll();
          $this->assertEquals([], $result);
        }

        function test_find() {
          //Arrange;
          $name = "Home stuff";
          $id = null;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "Wash the dog";
          $due_date = "2015-03-25 00:00:00";
          $category_id = $test_category->getId();
          $test_task = new Task($description, $id, $category_id, $due_date);
          $test_task->save();

          $description2 = "Water the lawn";
          $due_date = "2015-03-25 00:00:00";
          $test_task2 = new Task($description2, $id, $category_id, $due_date);
          $test_task->save();

          //Act;
          $result = Task::find($test_task->getId());

          //Assert
          $this->assertEquals($test_task, $result);
        }

        function test_get_date() {
          //arrange
          $name = "Garage stuff";
          $id = null;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "Put tools away";
          $due_date = "2016-03-25";
          $category_id = $test_category->getId();
          $test_task = new Task($description, $id, $category_id, $due_date);
          $test_task->save();

          //act
          $result = $test_task->getDueDate();

          //assert
          $this->assertEquals($due_date, $result);

        }

        function test_sort_by_date() {
          //arrange
          $name = "Garage stuff";
          $id = null;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "Put tools away";
          $due_date = "2016-03-25 00:00:00";
          $category_id = $test_category->getId();
          $test_task = new Task($description, $id, $category_id, $due_date);
          $test_task->save();

          $description2 = "Sweep Floor";
          $due_date2 = "2016-01-25 00:00:00";
          $category_id2 = $test_category->getId();
          $test_task2 = new Task($description2, $id, $category_id2, $due_date2);
          $test_task2->save();

          //act
          $result = Task::getAll();
          //assert
          $this->assertEquals([$test_task2, $test_task], $result);
        }
    }

 ?>
