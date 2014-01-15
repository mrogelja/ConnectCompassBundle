<?php
/**
 * Created by IntelliJ IDEA.
 * User: hypermedia
 * Date: 14/01/14
 * Time: 14:38
 * To change this template use File | Settings | File Templates.
 */

namespace Mr\ConnectCompassBundle\Templating;


class TemplateManager {
    protected $engine;
    protected $views;

    /**
     * @param array $templatingConfig
     */
    public function __construct($templatingConfig)
    {
        $this->engine = $templatingConfig['engine'];
        $this->views  = $templatingConfig['views'];
    }

    /**
     * Get the template related to key.
     *
     * Nota : $id is a dot (.) separated config templating.views key.
     *
     * @param $id
     * @param null $default
     * @return null|string
     */
    public function getTemplate($id, $default = NULL)
    {
        $keys  = explode('.', $id);
        $views = $this->views;

        foreach ($keys as $key) {
          if (isset($views[$key])) {
              $views = $views[$key];
          } else {
              return $default;
          }
        }

        if (is_string($views)) {
            return $views;
        }
    }
}