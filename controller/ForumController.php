<?php

    namespace Controller;

    use App\Session;
    use APP\manager;
    use App\User;
    use App\AbstractController;
    use App\ControllerInterface;
    use Model\Managers\TopicManager;
    use Model\Managers\PostManager;
    use Model\Managers\CategoryManager;
    use Model\Managers\UserManager;
    use Model\Managers\MessageManager;
    
    
    class ForumController extends AbstractController implements ControllerInterface{

        public function index(){
          
           //methode pour afficher les listes de topics
           $topicManager = new TopicManager();
           $categoryManager = new CategoryManager();
           // $categoryManager = new TopicManager;
           $categories = $categoryManager->findAll(["nameCategory", "ASC"]);
           
            return [
                "view" => VIEW_DIR."home.php",
                "data" => [
                    "topics" => $topicManager->findAll(["creationdate", "DESC"]),
                    'categories' => $categories,
                ]
            ];
        
        }
      
        ////////////////////////////////////////////////////////////////////////////////////////////////////
        // pour afficher les detais de topic qui sont appartenir au user  quand cliquer sur le pseudo de user
         public function detailsTopicByUser($id){
            
            $topicManager = new TopicManager();
            $userManager = new UserManager();
            
            return [
                "view" => VIEW_DIR . "forum/detTopicByUse.php",
                "data" => [
                    "topics" => $topicManager->TopicUser($id),  // Récupérez les topics correspondant à l'id
                    "user" => $userManager->findOneById($id),    // Récupérez l'utilisateur correspondant à l'id
                ]
            ];
           
        }

        // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // pour afficher les detais de topic   quand cliquer sur le title de topic depent  id topic
        public function detailTopicById($id){
            $topicManager = new TopicManager();
            return [
                "view" => VIEW_DIR."forum/detailTopic.php",
                "data" => [
                    "topic" => $topicManager->findOneById($id),
                ]
            ];
        }

        // ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // detail page for one category 
         public function detailCategory($id){

            $categoryManager = new CategoryManager();
            $topicManager = new TopicManager();

            return [
                "view" => VIEW_DIR."forum/detailCategory.php",
                "data" => [
                    "categories" => $categoryManager->findOneById($id),
                    "topics" =>$topicManager->TopicCategory($id),
                ]
            ];
        }
      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      public function addTopic() {
        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
    
        $topics = $topicManager->findAll();  // Récupérer tous les sujets de la base de données
        $categories = $categoryManager->findAll();  // Récupérer toutes les catégories de la base de données
    
        if (!empty($_POST) && isset($_POST['token']) && isset($_GET['id'])) {
            // Vérifier la présence du jeton dans le formulaire et en session
            if (!isset($_SESSION['token'])) {
                exit("Token not set");
            }
    
            // Vérifier si le jeton du formulaire est le même que le jeton en session
            if ($_POST['token'] == $_SESSION['token']) {
                // Vérifier si le jeton a expiré
                if (time() >= $_SESSION['token-exp']) {
                    exit("Your token has expired. Reload the form");
                }
    
                $user = Session::getUser()->getId();
    // var_dump($user);
                $categoryId = $_GET['id'];
    
                $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                if ($title) {

                    // Créer un nouveau sujet
                    $newTopic = [
                        "title" => $title,
                        "content" => $content,
                        "user_id" => $user,
                        "category_id" => $categoryId,  // Utiliser l'ID de la catégorie
                        "creationdate" => date("Y-m-d H:i:s"),
                        "lockTopic" => 0,
                    ];
    // var_dump($newTopic);
                    $topicManager->add($newTopic);  // Insérer le nouveau sujet dans la base de données
                    header("location:index.php?ctrl=forum&action=detailcategory&id=" . $categoryId);
                    unset($_SESSION["token"]); // Supprimez la variable de session "token", qui est généralement utilisée pour prévenir les attaques de type CSRF (Cross-Site Request Forgery) en associant un jeton unique à chaque formulaire.
                    unset($_SESSION["token-exp"]); unset($_SESSION["token-exp"]); //Supprime la variable de session "token-exp", qui stocke le temps d'expiration du jeton. Cela contribue à renforcer la sécurité en limitant la durée pendant laquelle le jeton est considéré comme valide, notamment ainsi la fenêtre d'attaque potentielle
                }
    
                return [
                    "view" => VIEW_DIR . "forum/nouveauTopic.php",
                    "data" => [
                        "topics" => $topics,
                        "category_id" => $categories,
                        "title" => $title,
                        "content" => $content,
                        "user_id" => $user,
                        "creationdate" => date("Y-m-d H:i:s"),
                        "lockTopic" => 0,
                    ]
                ];
            } else {
                exit("Error invalid token");
            }
        }
    
        return [
            "view" => VIEW_DIR . "forum/listTopics.php",
            "data" => [
                "topics" => $topics,
                "categories" => $categories,
            ]
        ];
    }
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////              delete   topic           ///////////////////////////////// 
    public function deleteTopic($id) {  
        $topicManager = new TopicManager();
        $user = Session::getUser()->getId();
        $topic = $topicManager->findOneById($id);
        $admin = $topicManager->findIfAdmin($user);
        $topicAuthor = $topicManager->TopicUser($user, $topic);
    
        if ($admin || $topicAuthor) {
            $success = $topicManager->deleteTopic($id);
    
            if ($success) {
                // Récupérez les données nécessaires après la suppression
                $topics = $topicManager->findAll();
                $categoryManager = new CategoryManager();
                $categories = $categoryManager->findAll(["nameCategory", "ASC"]);
    
                return [
                    "view" => VIEW_DIR . "home.php",
                    "data" => [
                        "topics" => $topics,
                        "categories" => $categories,
                    ]
                ];
            } else {
                echo "Le topic n'est pas supprimé";
            }
        } else {
            // Récupérez les données nécessaires si l'utilisateur n'est pas un admin
            $topic = $topicManager->findOneById($id);
            return [
                "view" => VIEW_DIR . "forum/detailTopic.php",
                "data" => [
                    "topic" => $topic,
                ]
            ];
        }
    }
    
   
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////              Add  message   topic           ///////////////////////////////// 
    public function addMessage() {
        $topicManager = new TopicManager();
        $messageManager = new MessageManager();
    
        if (!empty($_POST) && isset($_POST['token']) && isset($_GET['id'])) {
            // ... (Previous code remains unchanged)
    
            $user = Session::getUser()->getId();
            $topicId = $_GET['id'];  // Corrected variable name to $topicId
    
            $topic = $topicManager->findOneById($topicId);  // Retrieve the topic based on the topicId
    
            if ($topic) {  // Check if the topic exists
                $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
                if ($text) {
                    $messageManager->add([
                        "text" => $text,
                        "user_id" => $user,
                        "topic_id" => $topicId,  // Use the corrected variable name
                    ]);
    
                    Session::addFlash("success", "Message added");
                    // Redirect to the detailTopic.php view with appropriate data
                    return [
                        "view" => VIEW_DIR . "forum/detailTopic.php",
                        "data" => [
                            "topic" => $topicManager->findOneById($topicId),  // Adjust this line based on your requirements
                            // Add any other data you want to pass to the view
                        ],
                    ];
                } else {
                    Session::addFlash("error", "Topic locked");
                }
            } else {
                // Handle the case when the topic does not exist
                // Redirect to an appropriate view or show an error message
            }
    
            // Redirect to the detailTopic.php view without adding a message
            return [
                "view" => VIEW_DIR . "forum/detailTopic.php",
                "data" => [
                    "topic" => $topicManager->findOneById($topicId),  // Adjust this line based on your requirements
                    // Add any other data you want to pass to the view
                ],
            ];
        }
    
        // Handle the case when the form is not submitted
        return [
            "view" => VIEW_DIR . "forum/detailTopic.php",  // Adjust this line based on your requirements
            "data" => [
                // Add any data you want to pass to the view when the form is not submitted
            ],
        ];
    }
    
   
    ////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////        lock           ///////////////////////////////
   
    public function lockTopic(){

        $topicManager = new TopicManager;

        $user = session::getUser()->getId();

        $admin = $topicManager->findIfAdmin($user); //see if user is admin 

        $topic = $_GET['id'];
        $topicAuthor = $topicManager->TopicUser($user, $topic);
    
        if ($admin || $topicAuthor){

            // see the status of the topic
            $status = $topicManager->lockStatus($topic);

            // if the topic is not locked then 
            if ($status) {

                $topicManager->addLock($topic);
                session::addFlash("success", "The topic has been locked");
                header("location:index.php?ctrl=forum&action=detailTopic&id=".$topic);
                
            } else {

                $topicManager->removeLock($topic);
                session::addFlash("success", "The topic has been unlocked");
                header("location:index.php?ctrl=forum&action=detailTopic&id=".$topic);

            }

        } else {

            session::addFlash("error", "Only admins can lock a topic");
            header("location:index.php?ctrl=forum&action=detailTopic&id=".$topic);
        }

    }
 /////////////////////////   
}   