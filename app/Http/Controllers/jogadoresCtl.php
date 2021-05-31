<?php
/* Created by @pedroLara */

namespace App\Http\Controllers;
use App\Jogador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class jogadoresCtl extends Controller
{

    private $tabela = 'Sistema_Jogadores';
    private $key = 'id_jogador';

    function set(Request $request){
        if($request->editar_jogadores == 'N'){
            //Add new Player
            $jogador = new Jogador();
            $jogador->nome_jogador = $request->nome_jogador;
            $jogador->nivel_jogador = $request->nivel_jogador;
            $jogador->goleiro_jogador = $request->goleiro_jogador;
            $exec = $jogador->save();

        } else if($request->editar_jogadores == 'S'){
            //Update an existing Player
            $key = $this->key;
            $exec = DB::table($this->tabela)->where($key,$request->$key)->update([
                'nome_jogador' => $request->nome_jogador,
                'nivel_jogador' => $request->nivel_jogador,
                'goleiro_jogador' => $request->goleiro_jogador
            ]);

        }

        $result = 0;
        if($exec >= 1 || $exec == true){
            $result = 1;
        }

        return $result;
    }

    function get(Request $request){
        $data = $this->toArray(DB::table($this->tabela)->orderBy('id_jogador','DESC')->get())[0];
        $html = '';

        if(count($data) > 0){
            $html = '
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nº ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Nível</th>
                        <th scope="col">Goleiro</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
            ';

            foreach ($data as $value){

                $nivel = 'Não selecionado';
                switch ($value->nivel_jogador){
                    case 1: $nivel = '<strong>1</strong> - Péssimo'; break;
                    case 2: $nivel = '<strong>2</strong> - Ruim'; break;
                    case 3: $nivel = '<strong>3</strong> - Mediano'; break;
                    case 4: $nivel = '<strong>4</strong> - Bom'; break;
                    case 5: $nivel = '<strong>5</strong> - Excelente'; break;
                    default: $nivel = 'Não selecionado'; break;
                }

                $goleiro = 'Sim';
                if($value->goleiro_jogador == 0){
                    $goleiro = 'Não';
                }

                $html .= '
                <tr>
                    <th>'.$value->id_jogador.'</th>
                    <td>'.$value->nome_jogador.'</td>
                    <td>'.$nivel.'</td>
                    <td>'.$goleiro.'</td>
                    <td>
                        <a onclick="editarJogador('.$value->id_jogador.')" class="btn btn-dark btn-sm peq mr-5"><i class="bi bi-pen"></i></a>
                        <a onclick="excluirJogador('.$value->id_jogador.')" class="btn btn-danger btn-sm peq"><i class="bi bi-x-circle"></i></a>
                    </td>
                </tr>
                ';
            }

            $html.= '
                </tbody>
            </table>
            ';

        } else {
            $html = '<div class="alert alert-dark text-center" role="alert"><i class="bi bi-info-circle mr-5"></i> Não foram encontrados registros. Cadastre ao lado!</div>';

        }

        return array('html' => $html);
    }

    function getOne(Request $request){
        $id_jogador = $request->id;
        $data = $this->toArray(DB::table($this->tabela)->where('id_jogador',$id_jogador)->get())[0][0];
        return json_encode($data);
    }

    function getPlayerById($id){
        return  $this->toArray(DB::table($this->tabela)->where('id_jogador',$id)->get())[0][0];
    }

    function getQtdPlayersByLevel($level){
        return count($this->toArray(DB::table($this->tabela)->where('nivel_jogador',$level)->get())[0]);
    }

    function getQtdPlayers(){
        return count($this->toArray(DB::table($this->tabela)->get())[0]);
    }

    function delete(Request $request){
        $id_jogador = $request->id;
        DB::table($this->tabela)->where('id_jogador',$id_jogador)->delete();
        return true;
    }

    function getAllPlayersToSelectOptions(Request $request){
        $data = $this->toArray(DB::table($this->tabela)->orderBy('id_jogador','DESC')->get())[0];
        $html = '';

        if(count($data) > 0){
            foreach ($data as $value){
                if($value->goleiro_jogador == 1){
                    $value->nivel_jogador .= '*1';
                }
                $html .= '<option value="'.$value->id_jogador.'#'.$value->nivel_jogador.'">'.$value->nome_jogador.'</option>';
            }
        }

        return array('html' => $html);
    }

    function sorteio(Request $request){
        //var_dump('<pre>',$request->all());die;

        $numberOfPlayersOnEachTeam = $request->numero;
        $totalNumberOfPlayers = $numberOfPlayersOnEachTeam * 2;
        $selectedPlayers = $request->selectJogadores;
        $totalNumberOfSelectedPlayers = count($selectedPlayers);
        $numberOfPossibleTeams = ceil($totalNumberOfSelectedPlayers / $numberOfPlayersOnEachTeam);

        $teams = array();

        $retorno = array('status' => null,'errorTitle' => null,'html' => null);

        if($totalNumberOfSelectedPlayers > 0){
            if($totalNumberOfSelectedPlayers >= $totalNumberOfPlayers){
                for($t = 1; $t <= $numberOfPossibleTeams; $t++){
                    $teams[] = array(
                        'coeficiente' => 0,
                        'jogadores' => array(),
                        'total_de_jogadores' => 0,
                        'sem_goleiro' => false,
                    );

                }

                for ($p = 1; $p <= $totalNumberOfPlayers; $p++) {
                    foreach ($teams as $key => $team){

                        if($p == 1){
                            //G O L E I R O

                            $findAGoalKeeper = false;

                            foreach ($selectedPlayers as $keyPlay => $player){
                                $identifiers = explode('#', $player);
                                $player_id = $identifiers[0];
                                $player_level = explode('*',$identifiers[1]);
                                $is_player_goalkeeper = false;

                                if(count($player_level) > 1){
                                    $is_player_goalkeeper = true;

                                }
                                $player_level = $player_level[0];

                                if($is_player_goalkeeper == true && $findAGoalKeeper == false){
                                    $teams[$key]['jogadores'][] = $player_id;
                                    $teams[$key]['total_de_jogadores'] = 1;
                                    $teams[$key]['coeficiente'] += $player_level;
                                    unset($selectedPlayers[$keyPlay]);
                                    $findAGoalKeeper = true;

                                }

                            }

                            if($findAGoalKeeper == false){
                                $teams[$key]['sem_goleiro'] = true;

                            }

                        } else {
                            //J O G A D O R E S

                            $outlier = 0;
                            $outlier_playerId = 0;
                            $outlier_playerKey = '';

                            foreach ($selectedPlayers as $keyPlay => $player){
                                $identifiers = explode('#', $player);
                                $player_id = $identifiers[0];
                                $player_level = explode('*',$identifiers[1])[0];

                                if($team['total_de_jogadores'] < $numberOfPlayersOnEachTeam){
                                    if($p % 2 == 0){
                                        if($player_level >= $outlier){
                                            $outlier_playerId = $player_id;
                                            $outlier_playerKey = $keyPlay;
                                            $outlier = $player_level;
                                        }

                                    } else {
                                        if($player_level <= $outlier){
                                            $outlier_playerId = $player_id;
                                            $outlier_playerKey = $keyPlay;
                                            $outlier = $player_level;
                                        }
                                    }
                                }

                            }

                            if($outlier_playerId != 0){
                                $teams[$key]['jogadores'][] = $outlier_playerId;
                                $teams[$key]['total_de_jogadores'] += 1;
                                $teams[$key]['coeficiente'] += $outlier;
                                unset($selectedPlayers[$outlier_playerKey]);
                            }

                        }

                    }

                }

                foreach ($teams as $key => $team){
                    $teams[$key]['coeficiente'] = number_format($team['coeficiente']/$team['total_de_jogadores'],2);

                }

            } else {
                $retorno['status'] = 1;
                $retorno['errorTitle'] = 'Número de jogadores insuficientes, selecione no mínimo '.$totalNumberOfPlayers.' jogadores.' ;

            }
        } else {
          $retorno['status'] = 1;
          $retorno['errorTitle'] = 'Nenhum jogador selecionado!';

        }


        if(count($teams) > 0){
            $html = '<div class="row">';
            foreach ($teams as $key => $team){

                $html_infos = '';
                $html_infos .= '<li class="list-group-item" style="background: #B2DFDB; color: #00796B"><i class="bi bi-graph-up mr-5"></i> Coeficiente: <strong>'.$team['coeficiente'].'</strong></li>';

                $i = 0;

                if($team['sem_goleiro'] == true){
                    $html_infos .= '<li class="list-group-item" style="background: #FFE0B2; color: #EF6C00"><i class="bi bi-exclamation-circle mr-5"></i> Sem Goleiro</li>';

                }

                $primeiro_goleiro = false;
                foreach ($team['jogadores'] as $player_key){
                    $complete_player = self::getPlayerById($player_key);

                    if($complete_player->goleiro_jogador == 1 && $primeiro_goleiro == false) {
                        $html_infos .= '<li class="list-group-item" style="background: #CFD8DC; color: #455A64"><i class="bi bi-person-square mr-5"></i> '.$complete_player->nome_jogador.'<small><span style="color: #90A4AE"> (Nv. '.$complete_player->nivel_jogador.')</span></small> | Goleiro</li>';
                        $primeiro_goleiro = true;

                    } else if($complete_player->goleiro_jogador == 1 && $primeiro_goleiro == true) {
                        $html_infos .= '<li class="list-group-item" >'.$complete_player->nome_jogador.'<small><span style="color: #BDBDBD"> (Nv. '.$complete_player->nivel_jogador.')</span></small><br><small><span style="color: #9E9E9E">(Jogará como jogador apesar de registrado como goleiro)</span></small></li>';
                    } else {
                        $html_infos .= '<li class="list-group-item">'.$complete_player->nome_jogador.'<small><span style="color: #BDBDBD"> (Nv. '.$complete_player->nivel_jogador.')</span></small></li>';

                    }

                    $i++;

                }

                $html .= '
                    <div class="col-lg-6">
                        <div class="card sombra" style="margin-bottom: 15px">
                            <div class="card-header black-bg">
                                Time '.($key + 1).'
                            </div>
                            <ul class="list-group list-group-flush">'.$html_infos.'</ul>
                        </div>
                    </div>
                ';

            }

            $html.= '</div>';
            $retorno['html'] = $html;

        } else {
            $retorno['html'] = '<div class="alert alert-dark text-center" role="alert"><i class="bi bi-info-circle mr-5"></i> Preencha os dados iniciais ao lado e clique em sortear para ver os times.</div>';
        }

        return $retorno;
    }
}
