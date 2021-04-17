<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use App\Models\POI;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });  

    $app->group('/poi', function(RouteCollectorProxy $group){

        $group->post('/add', function (Request $request, Response $response) {
            $description = $request->getParsedBody()['description'];
            $x = $request->getParsedBody()['x'];
            $y = $request->getParsedBody()['y'];
    
            $db = $this->get('db');
            $poi = new POI;
    
            $poi->__set('nome', $description)->__set('x', $x)->__set('y', $y);
    
            $result = $poi->cadastra($db);
            
            $response->getBody()->write(json_encode($result));
    
            return $response->withStatus(204);
        });

        $group->get('/list', function(Request $resquest, Response $response){
            $db = $this->get('db');
            $poi = new POI;
            $pois = $poi->getAll($db);

            $response->getBody()->write(json_encode($pois));

            return $response->withHeader('Content-type', 'application/json');
        });

        $group->post('/find', function(Request $request, Response $response){
            $x = $request->getParsedBody()['x'];
            $y = $request->getParsedBody()['y'];
            $dmax = $request->getParsedBody()['dmax'];

            $db = $this->get('db');
            $poi = new POI;
            $pois = $poi->getAll($db);
            $result = [];

            foreach($pois as $eachPoi){
                $dist = sqrt(pow($eachPoi['x'] - $x, 2) + pow($eachPoi['y'] - $y, 2));
                if($dist <= $dmax){
                    array_push($result, $eachPoi);
                }
            }

            $response->getBody()->write(json_encode($result));

            return $response->withHeader('Content-type', 'application/json');
        });        
    });  

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });
};
