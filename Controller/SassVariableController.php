<?php
/**
 * Created by IntelliJ IDEA.
 * User: hypermedia
 * Date: 13/01/14
 * Time: 10:26
 * To change this template use File | Settings | File Templates.
 */

namespace Mrogelja\ConnectCompassBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class SassVariableController extends Controller{

    /**
     */
    public function listAction($project)
    {
        $sassVariablesForm = array();
        $compassProject = $this->get('connect_compass_project_collection')->offsetGet($project);

        return $this->container->get('templating')->renderResponse(
            $this->get('connect_compass_templating')->getTemplate('sass_variable.list', 'MrogeljaConnectCompassBundle:SassVariable:list.html.twig'),
            array(
                'sass_variables' => $compassProject->getSassVariables(),
                'project' => $project
            )
        );
    }

    /**
     * @param $project
     * @param null $sassVariableName
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction($project, $sassVariableName = NULL)
    {
        $compassProject = $this->get('connect_compass_project_collection')->offsetGet($project);

        if (isset($sassVariableName)) {
            $sassVariable = $compassProject->getSassVariableByName($sassVariableName);
        }

        if (!isset($sassVariable)) {
            $sassVariableClass =  $this->container->getParameter('connect_compass_sass_variable.class');
            $sassVariable     = new $sassVariableClass;
        }

        $sassVariableForm = $this->createForm($this->get('connect_compass_sass_variable_type'), $sassVariable) ;

        $request = $this->getRequest();

        if ('POST' === $request->getMethod()) {
            $sassVariableForm->handleRequest($request);

            if (true === $success = $sassVariableForm->isValid()) {
                $compassProject->saveSassVariable($sassVariable);
            }

            if ($request->request->has('ajax')) {
                return new JsonResponse(array(
                    'success' => $success
                ));
            } else {
                $request->getSession()->getFlashBag()->add('success', $this->get('translator')->trans('form.change_sass_variable.success', array(
                    '%var%' => $sassVariable->getName()
                ), 'MrogeljaConnectCompassBundle'));
            }

            if ($request->request->has('redirect_url')) {
               return $this->redirect($request->request->get('redirect_url'));
            }
        }

        return $this->container->get('templating')->renderResponse(
            $this->get('connect_compass_templating')->getTemplate('sass_variable.update', 'MrogeljaConnectCompassBundle:SassVariable:update.html.twig'),
            array(
                'sass_variable_form' => $sassVariableForm->createView(),
                'project' => $project
            )
        );
    }

}