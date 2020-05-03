<?php
namespace Portfolio\View;

class View
{
    private $pdoStatement;

    /**
     * @param string $path
     * @param array $data
     * 
     * @return void
     */
    public function render(string $path, array $data=null): void
    {
        if($data!=null)
        {
            extract($data);
        }
       
        \ob_start();
        require(__DIR__.'/../View/'.$path.'.html.php');
        $pageContent = \ob_get_clean();

        require('base.html.php');
    }

    /**
     * @param string $path
     * @param array $data
     * 
     * @return void
     */
    public function renderBack(string $path, array $data=null): void
    {
        if($data != null)
        {
            extract($data);
        }
       
        \ob_start();
        require(__DIR__.'/../View/'.$path.'.html.php');
        $pageContent = \ob_get_clean();

        require('base_dashboard.html.php');
    }

     /**
     * fonction render($path')
     */
    public function redirectTo(string $url):void
    {
        header("Location: $url");
        exit();
    }

}