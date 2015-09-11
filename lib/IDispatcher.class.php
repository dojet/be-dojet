<?php
/**
 * IDispatcher
 *
 * @author leeyan (setimouse@gmail.com)
 * @since 2014 7 15
 */
namespace Dojet;

interface IDispatcher {

    function __construct(WebService $webService);

    public function dispatch($requestUri);

}
