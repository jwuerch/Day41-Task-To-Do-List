<?php
    require_once __DIR__ .'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Task.php';
    require_once __DIR__.'/../src/Category.php';

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=to_do';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });
// TASK PAGES
    $app->get("/tasks", function() use ($app) {
        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll(), 'categories' => Category::getAll()));
    });

    // $app->post("/tasks", function() use ($app) {
    //     $description = $_POST['description'];
    //     $category_id = $_POST['category_id'];
    //     $due_date = $_POST['due_date'];
    //     $task = new Task($description, $id = null, $category_id, $due_date);
    //     $task->save();
    //     $tasks = Task::getAll();
    //     $category = Category::find($category_id);
    //     return $app['twig']->render('category.html.twig', array('category' => $category, 'tasks' => $category->getTasks(), 'tasks_all' => $tasks));
    // });

    $app->post("/add_task", function() use ($app) {
        $description = $_POST['description'];
        $due_date = $_POST['due_date'];
        $id = null;
        $new_task = new Task($description, $id, $due_date);
        $new_task->save();
        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll(), 'categories' => Category::getAll()));
    });

    $app->get("/task/{id}", function($id) use ($app) {
        $task = Task::find($id);
        $categories = $task->getCategories();
        return $app['twig']->render('task.html.twig', array('categories' => $categories, 'task' => $task, 'all_categories' => Category::getAll()));
    });

    $app->post("/task_add_category", function() use($app) {
        $category = Category::find($_POST['category_id']);
        $task = Task::find($_POST['task_id']);
        $category = $task->addCategory($category);
        return $app['twig']->render('task.html.twig', array('task' => $task, 'categories' => $task->getCategories(), 'all_categories' => Category::getAll()));
    });

    $app->post("/delete_tasks", function() use ($app) {
        Task::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->patch("/task/{id}/update", function($id) use ($app) {
        $task = Task::find($id);
        $new_description = $_POST['new_description'];
        $new_due_date = $_POST['new_due_date'];
        $task->update($new_description, $new_due_date);
        $categories = $task->getCategories();
        return $app['twig']->render('task.html.twig', array('categories' => $categories, 'task' => $task, 'all_categories' => Category::getAll()));
    });

    $app->delete("/task/{id}/delete", function($id) use ($app) {
        $task = Task::find($id);
        $task->delete();
        return $app['twig']->render('tasks.html.twig', array('tasks' => Task::getAll()));
    });
// CATEGORY PAGES
    $app->get("/categories", function() use ($app) {
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/add_category", function() use ($app) {
        $category = new Category($_POST['name']);
        $category->save();
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->get("/category/{id}", function($id) use ($app) {
      $category = Category::find($id);
      return $app['twig']->render('category.html.twig', array('category' => $category, 'tasks' => $category->getTasks(), 'all_tasks' => Task::getAll()));
    });

    $app->post("/category_add_task", function() use ($app) {
        $category = Category::find($_POST['category_id']);
        $task_id = $_POST['task_id'];
        $task = Task::find($task_id);
        $category->addTask($task);
        return $app['twig']->render('category.html.twig', array('all_tasks' => Task::getAll(), 'tasks' => $category->getTasks(), 'category' => $category));
    });

    $app->post("/delete_categories", function() use ($app) {
        Category::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    $app->patch("/category/{id}/update", function($id) use ($app) {
        $category = Category::find($id);
        $new_name = $_POST['new_name'];
        $category->update($new_name);
        $tasks = $category->getTasks();
        return $app['twig']->render('category.html.twig', array('all_tasks' => Task::getAll(), 'tasks' => $category->getTasks(), 'category' => $category));
    });

    $app->delete("/category/{id}/delete", function($id) use ($app) {
        $category = Category::find($id);
        $category->delete();
        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->post("/delete_all", function() use ($app) {
        Task::deleteAll();
        Category::deleteAll();
        return $app['twig']->render('index.html.twig');
    });

    return $app;
?>
