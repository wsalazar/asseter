<?php
/**
 * Created by PhpStorm.
 * User: willsalazar
 * Date: 12/22/14
 * Time: 11:15 PM
 */

namespace Asseter\AssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Asseter\AssetsBundle\Form\AssetsType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AssetsController
 * @package Asseter\AssetsBundle\Controller
 */

class AssetsController extends Controller
{
    /**
     * @Route("/user-dashboard", name="user_dashboard")
     */
    public function dashboardAction(Request $request)
    {
        $user = $request->request;
        echo '<pre>';
        var_dump($user);
        die();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($this->get('security.token_storage')->isGranted('ROLE_USER')) {
            $assetsForm = $this->createForm(new AssetsType);
            $assetsForm->handleRequest($request);
            return $this->render(
                'AsseterAssetsBundle:Assets:dashboard.html.twig',
                ['assets'=>$assetsForm->createView()]
            );
        }
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();

        return $this->render(
            'AsseterUserBundle:Assets:index.html.twig'
        );
    }
} 