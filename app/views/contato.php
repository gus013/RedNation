<?php

use App\Library\Formulario;

echo $this->loadView("comuns/cabecalho");
echo $this->loadView("comuns/menu");

?>

<section>
    <div class="container">
        <div class="blog-banner">
            <div class="mt-5 mb-5 text-center">
                <h1 style="color: #DC143C;">Contato do Desenvolvedor</h1>
            </div>
            <div class="mt-5 mb-5 text-center">
                <h6 style="color: #DC143C;">Caso tenha alguma dúvida ou queira enviar algum comentario para
                o desenvolvedor, entre em contato por email.</h6>
            </div>
        </div>
        <?= Formulario::exibeMsgError() . Formulario::exibeMsgSucesso() ?>
    </div>
</section>

<section class="section-margin--small" >
    <div class="container">
        <!-- <div class="d-none d-sm-block mb-5 pb-4">
            <div id="map" style="height: 420px;"></div>
            <script>
                function initMap() {
                var uluru = {lat: -21.1324524, lng: -42.3678246};
                var grayStyles = [
                    {
                    featureType: "all",
                    stylers: [
                        { saturation: -90 },
                        { lightness: 50 }
                    ]
                    },
                    {elementType: 'labels.text.fill', stylers: [{color: '#A3A3A3'}]}
                ];
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: -21.1324524, lng: -42.3678246},
                    zoom: 17,
                    styles: grayStyles,
                    scrollwheel:  false
                });
                }
                
            </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpfS1oRGreGSBU5HHjMmQ3o5NLw7VdJ6I&callback=initMap"></script>
            
        </div> -->

        <div class="row">

            <div class="col-md-4 col-lg-3 mb-4 mb-md-0">                
                <div class="media contact-info">
                <span class="contact-info__icon"><i class="ti-email" style="color: #DC143C"></i></span>
                <div class="media-body">
                    <h3><a href="mailto:iigustavow@gmail.com">iigustavow@gmail.com</a></h3>
                    <p class="text-danger mt-3"><b>Entre em contato! Me envie um email!</b></p>
                </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-9">
                <form action="<?= SITEURL ?>Home/contatoEnviaEmail" class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm" novalidate="novalidate">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <p class="text-danger"><b>Nome</b></p>
                                <input class="form-control" name="nome" id="nome" type="text" placeholder="Nome">
                            </div>
                            <div class="form-group">
                                <p class="text-danger"><b>Telefone</b></p>
                                <input class="form-control" name="celular" id="celular" type="text" placeholder="Fone">
                            </div>
                            <div class="form-group">
                                <p class="text-danger"><b>E-mail</b></p>
                                <input class="form-control" name="email" id="email" type="email" placeholder="E-mail">
                            </div>
                            <div class="form-group">
                                <p class="text-danger"><b>Assusto</b></p>
                                <input class="form-control" name="assunto" id="assunto" type="text" placeholder="Assunto">
                            </div>

                            <div class="form-group">
                                <textarea class="form-control different-control w-100" name="mensagem" id="mensagem" cols="30" rows="5" placeholder="Descreva de forma detalha o motivo do seu contato"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center text-md-right mt-3">
                        <button type="submit" class="button button--active button-contactForm bg-danger">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="<?= SITEURL ?>assets/ckeditor5/ckeditor.js"></script>

<script type="text/javascript">
    ClassicEditor
        .create( document.querySelector('#mensagem'))
        .catch( error => {
            console.error( error );
        })
</script>

<?= $this->loadView("comuns/rodape") ?>