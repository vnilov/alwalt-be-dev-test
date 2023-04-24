<?php
require_once __DIR__.'/vendor/autoload.php';

use App\Application\Exceptions\ImageNotFoundException;
use App\Application\Exceptions\ModifierException;
use App\Application\Exceptions\ValidationException;
use App\Http\Controllers\ImageController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

require_once 'config.php';

$request = Request::createFromGlobals();

$routes = new RouteCollection();
$routes->add('modifyImage', new Route('/{filename}/', methods: "GET"));

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $response = call_user_func([new ImageController(), 'getModified'], $request);
} catch (ValidationException $exception) {
    $response = new Response($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
} catch (ImageNotFoundException|ResourceNotFoundException $exception) {
    $response = new Response($exception->getMessage(), Response::HTTP_NOT_FOUND);
} catch (ModifierException $exception) {
    $response = new Response($exception->getMessage(), Response::HTTP_BAD_REQUEST);
} catch (Throwable $exception) {
    $response = new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
} finally {
    $response->send();
}
