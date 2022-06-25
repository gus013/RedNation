<?php

namespace App\Library;

class Formulario
{
    /**
     * titulo
     *
     * @param string $titulo 
     * @param array $parametro 
     * @return string
     */
    public static function titulo($titulo, $parametro = [])
    {
        // Seta sub titulo
        if (isset($parametro['acao'])) {

            if ($parametro['acao'] == "insert") {
                $titulo .= " - Novo";
            } else if ($parametro['acao'] == "update") {
                $titulo .= " - Alteração";
            } else if ($parametro['acao'] == "delete") {
                $titulo .= " - Exclusão";
            } else if ($parametro['acao'] == "view") {
                $titulo .= " - Visualização";
            }
        }

        $textoBtnNovo = "";

        if (!isset($parametro['btNovo'])) {
            $textoBtnNovo = '
                            <a href="'. SITEURL . $parametro['controller'] .'/form/insert" class="btn btn-secondary btn-sm btn-icons-crud" title="Novo">
                                <i class="fa fa-plus" area-hidden="true"></i>
                            </a>
            ';
        }

        $texto = '
                    <section>
                        <div class="container">
                            <div class="blog-banner">
                                <div class="row">
                                    <div class="col-10 mt-5 mb-5 text-left">
                                        <h1 style="color: #384aeb;">' . $titulo . '</h1>
                                    </div>
                                    <div class="col-2 mt-5 mb-5 text-right">
                                        ' . $textoBtnNovo . '
                                        <a href="' . SITEURL .'/' . $parametro['controller'] .'" class="btn btn-secondary btn-sm btn-icons-crud" title="Lista">
                                            <i class="fa fa-list" area-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>';

                    $texto .= Formulario::exibeMsgError() . Formulario::exibeMsgSucesso() . Formulario::exibeMsgErrorValidacao();

                    $texto .= '
                            </div>
                        </div>
                    </section>';

        return $texto;

    }

    /**
     * exibeMsgError
     *
     * @return string
     */
    public static function exibeMsgError() 
    {
        $texto = "";

        if (Session::get('msgError') != "") {

            $texto .= '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>'. Session::getDestroy('msgError') . '</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';

        }

        return $texto;
    }

    /**
     * exibeMsgError
     *
     * @return string
     */
    public static function exibeMsgErrorValidacao() 
    {
        $texto = "";

        if (Session::get('errors') != "") {

            $aErrors = Session::getDestroy('errors');
            $aErrors = (is_null($aErrors) ? [] : $aErrors);
            $textoError = "";

            foreach ($aErrors as $value) {
                $textoError .= ($textoError != "" ? "<br />" : "") . $value;
            }

            $texto .= '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>'. $textoError . '</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';

        }

        return $texto;
    }


    /**
     * exibeMsgSucesso
     *
     * @return string
     */
    public static function exibeMsgSucesso() 
    {
        $texto = "";

        if (Session::get('msgSucesso') != "") {

            $texto .= '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>'. Session::getDestroy('msgSucesso') . '</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>';

        }

        return $texto;
    }

    /**
     * getDataTables
     *
     * @param string $table_id 
     * @return string
     */
    public static function getDataTables($table_id)
    {
        return '
            <script>
                $(document).ready( function () {
                    $("#' . $table_id . '").DataTable( {
                        language:   {
                                        "sEmptyTable":      "Nenhum registro encontrado",
                                        "sInfo":            "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                                        "sInfoEmpty":       "Mostrando 0 até 0 de 0 registros",
                                        "sInfoFiltered":    "(Filtrados de _MAX_ registros)",
                                        "sInfoPostFix":     "",
                                        "sInfoThousands":   ".",
                                        "sLengthMenu":      "_MENU_ resultados por página",
                                        "sLoadingRecords":  "Carregando...",
                                        "sProcessing":      "Processando...",
                                        "sZeroRecords":     "Nenhum registro encontrado",
                                        "sSearch":          "Pesquisar",
                                        "oPaginate": {
                                            "sNext":        "Próximo",
                                            "sPrevious":    "Anterior",
                                            "sFirst":       "Primeiro",
                                            "sLast":        "Último"
                                        },
                                        "oAria": {
                                            "sSortAscending":   ": Ordenar colunas de forma ascendente",
                                            "sSortDescending":  ": Ordenar colunas de forma descendente"
                                        }
                                    }
                    });
                } );
            </script>
        ';
    }
}