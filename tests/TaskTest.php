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

        function testGetCategories()
        {
            // Arrange
            $name = "Work stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Volunteer stuff";
            $id = null;
            $test_category2 = new Category($name2, $id);
            $test_category2->save();

            $description = "Reply to emails";
            $id = null;
            $due_date = "2016-03-01";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            // Act
            $test_task->addCategory($test_category);
            $test_task->addCategory($test_category2);

            // Assert
            $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);
        }

        function testAddCategory()
        {
            // Arrange
            $name = "Work stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Reply to emails";
            $id = null;
            $due_date = "2016-03-01";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            // Act
            $test_task->addCategory($test_category);

            // Assert
            $this->assertEquals($test_task->getCategories(), [$test_category]);
        }

        function testDelete() {
            //Arrange;
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

            //Act;
            $test_task2->delete();

            //Assert;
            $this->assertEquals([$test_task], Task::getAll());
        }

        function testUpdate()
        {
            // Arrange
            $description = "Put tools away";
            $id = 1;
            $due_date = "2016-03-25";
            $test_task = new Task($description, $id, $due_date);
            $test_task->save();

            $new_description = "Sweep floor";
            $new_due_date = "2016-03-01";

            // Act
            $test_task->update($new_description, $new_due_date);
            $result = [$test_task->getDescription(), $test_task->getDueDate()];

            // Assert
            $this->assertEquals(["Sweep floor", "2016-03-01"], $result);
        }
    }

 ?>
