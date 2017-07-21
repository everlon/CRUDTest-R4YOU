<div class="jumbotron">
    <h3 class="display-5">
    <?php
        if(!$produto['id']) {
            echo 'Novo produto';
        } else {
            echo 'Editar produto';
        }
    ?>
    </h3><hr>

        <div class="bd-example" data-example-id="">
        <form action="<?php echo BASEURL; ?>?p=adicionar" method="post">
            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
            <div class="form-group">
                <label for="exampleInputEmail1">Nome do produto*</label>
                <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome do produto" value="<?php echo $produto['nome']; ?>" required />
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Preço*</label>
                <input id="preco" name="preco" type="text" class="form-control" placeholder="Preço" value="<?php echo $produto['preco']; ?>" required />
            </div>
            <div class="form-group">
                <label for="exampleTextarea">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3"><?php echo $produto['descricao']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="<?php echo BASEURL; ?>" class="btn " title="Produtos">Cancelar</a>
        </form>
        </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#preco').mask("#.##0,00", {reverse: true});
    });
</script>
