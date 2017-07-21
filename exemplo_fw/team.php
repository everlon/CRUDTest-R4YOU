<?php
/**
 * Author: Everlon Passos (dev@everlon.com.br)
 * Date update: 06/09/2015 14:01:24
 */
     $team = $app['controllers_factory'];



               # Área restrita no arquivo todo
               $team->before(function() use ($app) {
                    if(!$app['session']->get('is_user')) { return $app->redirect(URL_BASE.'/login'); }
               });

               # Variáveis gerais
               $query = ' ORDER BY nome';
               $user  = $app['session']->get('id_user');



     $team->get('/show/{id}', function($id) use ($app) {

          if (!$id) { return $app['twig']->render('painel/team_form.twig' ); }
          else {
               $data = $app['db']::findOne('team', 'id = ? ', [$id]);
               return $app['twig']->render('painel/team_form.twig', ['data'=>$data] );
          }
     })
          ->value('id', null)
          ->bind('team_show');



     $team->post('/save', function() use ($app, $query) {
          # Onomástica

          $post            = $app['db']::dispense('team');
          if (!empty($app['request']->get('id'))) {
               $post->id = $app->escape($app['request']->get('id'));
          }
          $post->nome      = htmlentities($app->escape($app['request']->get('nome')));
          $post->codigo    = $app->escape($app['request']->get('codigo'));
          $post->status    = $app['request']->get('status');
          $post->email     = $app->escape($app['request']->get('email'));
          $post->telefone1 = $app['helper']->onlyNumber($app->escape($app['request']->get('telefone1')));
          $post->telefone2 = $app['helper']->onlyNumber($app->escape($app['request']->get('telefone2')));
          $post->bio       = $app['request']->get('bio');
          $post->data_cad  = date("Y-m-d H:i:s");
          $return_id       = $app['db']::store($post);

          if ($app['request']->get('id') == '') {
               $data = $app['db']::findOne('team', 'id = ? ', [$post->id]);
               return $app['twig']->render('painel/team_form.twig', ['data'=>$data, 'notice'=>'Salvo com sucesso!'] );
          }

          $data = $app['db']::findAll('team', ' ORDER BY nome ');
          return $app['twig']->render('painel/team_list.twig', ['data'=>$data, 'notice'=>'Corretor salvo com sucesso!'] );
     })
          ->bind('team_save');



     $team->get('/del/{id}', function($id) use ($app) {
          $data = $app['db']::findOne('team', 'id = ? ', [$id]);
          $app['db']::trash( $data );

          if (file_exists($data->imagem)) { unlink( UPLOADS."/fotos/".$data->imagem); }

          $data = $app['db']::findAll('team', ' ORDER BY nome ');
          return $app['twig']->render('painel/team_list.twig', ['data'=>$data, 'notice'=>'Excluído com sucesso!'] );
     })
          ->bind('team_del');



    # Enviar foto
    $team->post('/upload_imagem', function() use ($app) {

          $id = $app->escape( $app['request']->get('id') );

          $img = $app['ImageWorkshop']::initFromPath($_FILES['file']['tmp_name']);
          $img->resizeInPixel( 360, null, true );

          $dirPath         = UPLOADS."/fotos";
          $filename        = "foto-$id.jpg";
          $createFolders   = true;
          $backgroundColor = null;
          $imageQuality    = 95;

          $img->save($dirPath, $filename, $createFolders, $backgroundColor, $imageQuality);

          $post           = $app['db']::dispense('team');
          $post->id       = $id;
          $post->imagem   = $filename;
          $post->data_cad = date("Y-m-d H:i:s");
          $return_id      = $app['db']::store($post);

          $data = [ 'notice' => '<i class="uk-icon-check"></i> Imagem enviada!' ];
          return $app->json($data, 201, array('Content-Type'=>'text/json'));
    })
          ->bind('uploadImgTeam');



     $team->match('/{order}', function($order) use ($app) {
          $busca = $app->escape( $app['request']->get('busca') );

          if (!empty($busca)) {
               $data = $app['db']::find('team', ' nome LIKE ? ', ["%".$busca."%"] );
          } else {
               $data = $app['db']::findAll('team', " ORDER BY nome,? ", [$order]);
          }

          return $app['twig']->render('painel/team_list.twig', ['data'=>$data] );
     }, 'GET|POST')
          ->value('order', 'ASC')
          ->bind('team');



     return $team;
