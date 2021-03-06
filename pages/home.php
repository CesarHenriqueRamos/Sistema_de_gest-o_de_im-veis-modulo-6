<?php 
$preco = '';
$area = "";
$cidade = "";
$tipo = '';
$acao = '';
if(@$_POST['pesquisar']){
    //print_r($_POST);
    $preco = @$_POST['preco'];
    $area = @$_POST['area'];
    $cidade = @$_POST['cidade'];
    $tipo = @$_POST['tipo'];
    $acao = @$_POST['acao'];
    $query ="";
    if($cidade != ''){
        $query = $query." cidade = '$cidade'";
    }
    if($area != ''){
        $query = $query." && area <= '$area'";
    }
    if($preco != ''){
        $query = $query." && valor <= '$preco'";
    }
    if($acao != ''){
        $query = $query." && alugar_vender = '$acao'";
    }       
    
    if($tipo != ''){
        $query = $query." && comercial_residencial = '$tipo'";
    }
        $sql = MySql::connect()->prepare("SELECT * FROM `tb_admin.imoveis` WHERE $query");
        $sql->execute();
        $dados = $sql->fetchAll();
      
        //echo $query;
    
}else{
    $sql = MySql::connect()->prepare("SELECT * FROM `tb_admin.imoveis`");
    $sql->execute();
    $dados = $sql->fetchAll();  
}      

?>
<section class="busca">
    <div class="container">
        
        <form action="" method="post">
        <div class="box-form w33">
                <label for="preco">O que você precisa?</label>
                <br>
                <select name="acao" style="color:#1b5e20;background-color: #00e676; ">
                    <option <?php if($acao == 'comprar') echo 'selected' ?> value="comprar"> Comprar</option>
                    <option <?php if($acao == 'alugar') echo 'selected' ?> value="alugar"> Alugar</option>
                </select>
            </div>
            <div class="box-form w33">
                <label for="preco">Qual Tipo?</label>
                <select name="tipo">
                    <option value=""></option>
                    <option <?php if($tipo == 'residencial') echo 'selected' ?> value="residencial"> Residencial</option>
                    <option <?php if($tipo == 'comercial') echo 'selected' ?> value="comercial"> Comercial</option>
                </select>
            </div>
            <div class="box-form w33">
                <label for="preco">Onde?</label>
                <select name="cidade">
                <?php
                    $sql = MySql::connect()->prepare("SELECT * FROM `tb_admin_cidade`");
                    $sql->execute();
                    $cidade = $sql->fetchAll();
                    foreach($cidade as $key => $value){
                ?>
                    <option <?php if($cidade == $value['nome']) echo 'selected'; ?> value="<?php echo $value['nome'];?>"> <?php echo $value['nome'];?></option>
                    <?php } ?>
                    
                    
                </select>
            </div>
            <div class="box-form w33">
                <label for="preco">Faicha de Preço?</label>
                <select name="preco">
                    <option value=""></option>
                    <option <?php if($preco == '100.000,00') echo 'selected' ?> value="100.000,00"> até 100.000,00</option>
                    <option <?php if($preco == '200.000,00') echo 'selected' ?> value="200.000,00"> até 200.000,00</option>
                    <option <?php if($preco == '300.000,00') echo 'selected' ?> value="300.000,00"> até 300.000,00</option>
                    <option <?php if($preco == '400.000,00') echo 'selected' ?> value="400.000,00"> até 400.000,00</option>
                    <option <?php if($preco == '500.000,00') echo 'selected' ?> value="500.000,00"> até 500.000,00</option>
                </select>
            </div>
            <div class="box-form w33">
                <label for="preco">Área?</label>
                <select name="area">
                    <option value=""></option>
                    <option <?php if($area == '50') echo 'selected' ?> value="50"> até 50m²</option>
                    <option <?php if($area == '100') echo 'selected' ?> value="100"> até 100m²</option>
                    <option <?php if($area == '150') echo 'selected' ?> value="150"> até 150m²</option>
                    <option <?php if($area == '200') echo 'selected' ?> value="200"> até 200m²</option>
                </select>
            </div>
            <div class="box-form w33">
               <input type="submit" name="pesquisar" value="Pesquisar">
        </form>
        <div class="clear"></div>
    </div><!--container-->
</section>
<section class="imoveis">
    <div class="container">
        <?php
        
            foreach($dados as $key => $value){
                $imovel = $value['id'];
                $sql = MySql::connect()->prepare("SELECT * FROM `tb_admin.imovel_imagem` WHERE id_imovel = ?");
                $sql->execute(array($imovel));
                $imagem_imovel = $sql->fetch();  
            ?>
       <div class="imovel-single">
            <div class="imagem-imovel">
                <img src="painel/uploads/<?php echo $imagem_imovel['imagem'];?>" alt="">
            </div>
            <div class="dados-imovel">
                <div class="w50">
                    <h2><a href=""><?php echo $value['endereco']; ?></a></h2>
                    <h3><?php echo $value['cidade']; ?></h3>
                    <p>Valor: R$ <?php echo number_format($value['valor'],2,',','.'); ?></p>
                    <p>Área: <?php echo $value['area']; ?>m²</p>
                    <p>Tipo: <?php echo $value['comercial_residencial']; ?></p>
                    <div class="w50">
                        <p>Quartos: <?php echo $value['quartos']; ?></p>
                    </div>
                    <div class="w50">
                        <p>Vagas: <?php echo $value['vagas']; ?></p>
                    </div>
                </div>
                <div class="w50">
                    <h2>Contato:</h2>
                    <button>Contato</button>
                </div>
               
            </div>
       </div>
       <div class="clear"></div> 
        <?php } ?>
    </div><!--container-->
</section>