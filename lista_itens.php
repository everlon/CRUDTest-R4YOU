<?php
    function index() {
        global $produtos;
        $produtos = busca('produtos');
    }
    index();
?>

    <div class="row marketing">
        <div class="row">
            <?php
                foreach ($produtos as $produto) {
                    echo '<div class="col-sm-4 col-xs-1">';
                        echo '<div style="margin-bottom: 20px;">';
                        echo '<h4>'.$produto['nome'].'</h4>';
                        echo '<div>R$ '.$produto['preco'].'</div>';
                        echo '<div>'.$produto['descricao'].'</div>';
                        echo '<div class="btn-group" role="group">';
                            echo '<a href="'.BASEURL.'?p=editar&id='.$produto['id'].'" class="btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                            echo '<a href="'.BASEURL.'?p=apagar&id='.$produto['id'].'" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                        echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
