<?php

namespace PROJECT\View;

class View
{
    public static function makeView($view, array $params = [], $viewData = []): void
    {

        $baseContent = self::getBaseContent();
        $viewContent = self::getViewContent($view, false, $params , $viewData);
        echo str_replace("{{content}}", $viewContent, $baseContent);
    }

    protected static function getBaseContent()
    {
        ob_start();
        include base_path() . "views/layouts/main.php";
        return ob_get_clean();
    }

    public static function makeErrorView($error): void
    {
        self::getViewContent($error, true);
    }

    private static function getViewContent($view, $isError = false, array $params = [], $viewData = [])
    {

        $path = $isError ? view_path() . 'errors/' : view_path();
        if (str_contains($view, '.')):
            $views = explode('.', $view);
            foreach ($views as $view) :
                if (is_dir($path . "/" . $view)):
                    $path .= $view . '/';
                endif;
            endforeach;
            $view = $path . end($views) . ".php";

        else:
            $view = $path . $view . ".php";
        endif;
        foreach ($params as $key => $value):
            $$key = $value;
        endforeach;
        if ($isError):
            include $view;
        else:
            extract($viewData);
            ob_start();
            include $view;
            return ob_get_clean();
        endif;

    }
}