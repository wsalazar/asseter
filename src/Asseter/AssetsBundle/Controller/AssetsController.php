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
use Symfony\Component\HttpFoundation\Session;
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
        $user = $this->get('session')->get('user-session');
        $assetsForm = $this->createForm(new AssetsType);
        $assetsForm->handleRequest($request);
        return $this->render(
            'AsseterAssetsBundle:Assets:dashboard.html.twig',
            [
                'assets'    =>  $assetsForm->createView(),
                'user'      =>  $user
            ]
        );
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        return $this->redirect($this->generateUrl('user_user_homepage'));
    }
} 