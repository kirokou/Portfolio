<?php
/**
 * [new] [show] [edit]  [delete]
 */
namespace Portfolio\Controller;

use Portfolio\View\View;
use Portfolio\Model\Entity\Post;
use Portfolio\Controller\Controller;
//use Portfolio\Model\Manager\UserManager;

class PostController extends Controller
{
    protected $entity= "Post";
    
    /**
     * @param [type] $contenu
     * @return void
     */
    public function new()
    { 
        if(!isset($_POST) || empty($_POST))
        {
            $this->view->renderBack('backend/'.strtolower($this->entity).'/new');
        }
        else
        {
            $this->post->setImg($_FILES['img']['name']);
            $this->post->setTitle($_POST['title']);
            $this->post->setChapo($_POST['chapo']);
            $this->post->setContent($_POST['content']);
            $this->post->setSlug($_POST['title']);
           
            $saveIsOk = $this->postManager->insert($this->post);
            if($saveIsOk){
                $message = 'Félicitation. Votre Article bien été ajouté';
            } else{
                $message = 'Désolé. Une erreur est survenue. Action non effectuée';
            }
            // Liste de l'entité demandée. 
            $this->index($message);
        }
    }

    /**
    * A modifier. A Adpater 
    *
    * @param [type] $id
    * @return void
    */
    public function show()
    {
        // Post
        $id=htmlspecialchars($_GET['id']);
        $post= $this->postManager->find($id);
        // index posts
        $posts= $this->postManager->findAll();

        $this->view->render('frontend/'.strtolower($this->entity).'/show', compact('post', 'posts'));
    }

     /**
     * index du front
     * Affiche la liste de
     * @Route("/", name="")
     * @return void
     */
    public function list($message=false)
    {
        $em = strtolower($this->entity)."Manager";
        $items = $this->$em->findAll();
        // Render()
        $this->view->render('frontend/'.strtolower($this->entity).'/index', compact('items'));
       
    }


     /**
     * Fonction de modification
     * @return void
     */
    public function edit()
    {
         // S'il n'y a pas de soumission de formulaire
         if(!isset($_POST) || empty($_POST))
         {
            $id=htmlspecialchars($_GET['id']);
            $this->post = $this->postManager->find($id);

            $this->view->renderBack('backend/'.strtolower($this->entity).'/edit',[
                'post'=>$this->post
                ]);
         }
         else
         {
            $this->post= $this->postManager->find($_POST['id']);
            $this->post->setImg($_FILES['img']['name']);
            $this->post->setTitle($_POST['title']);
            $this->post->setChapo($_POST['chapo']);
            $this->post->setContent($_POST['content']);
            $this->post->setSlug($_POST['title']);

            $saveIsOk = $this->postManager->update($this->post);
            if($saveIsOk)
            {
                $message = 'Félicitation, votre Article a bien été modifiée';
                $this->saveImg();
            }else
            {$message = 'Désolé. Une erreur est survenu au niveau de la modification de votre article';}

            // Liste de l'entité demandée. 
            $this->index($message);
        }
    }

    /**
     * Fonction de suppression
     * @param [type] $recupPost
     * @return void
     */
    public function delete()
    {
        $id=htmlspecialchars($_POST['id']);
        $deleteIsOk = $this->postManager->delete($id);
        if($deleteIsOk){
            $message = 'Félicitation. le project bien été supprimée';
        }else
        {
            $message = 'Désolé. Une erreur est arrivée. Impossible de supprimer cette réalisation';
        }
       // Liste de l'entité demandée. 
       $this->index($message);
    }


    
}