<?php
namespace App\Controller;
use App\Entity\Post;
use App\WorkWithDB;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Driver\Connection;

define("POSTS_ON_PAGE", 5);

class MainController extends AbstractController
{

    /**
     * @Route("/view/{id}", name="view_post")
     */
    public function view(int $id): Response
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);
        if (!$post) {
            throw $this->createNotFoundException(
                'No post found for id='.$id
            );
        }
        return $this->render('pages/post.html.twig', [
            'post' => $post,
        ]);
    }
    /**
     * @Route("/{page}", name="index_page")
     */
    public function index(Connection $connection, WorkWithDB $workWithDB, int $page = 1): Response
    {
        $allPosts = $connection->fetchAll('SELECT * FROM post');
        $posts = $workWithDB->paginationPosts($allPosts, $page, POSTS_ON_PAGE);

        return $this->render('pages/index.html.twig', [
            'posts' => $posts,
            'activePage' => $page,
            'countPages' => ceil( count($allPosts)/POSTS_ON_PAGE),
                   ]);
    }
}