<?php
namespace sleifer\googleapi;

class DistanceMatrix{

    const TYPE_JSON = 'json';
    const TYPE_XML  = 'xml';

    const MODE_DRIVING   = 'driving'; 
    const MODE_WALKING   = 'walking'; 
    const MODE_BICYCLING = 'bicycling'; 
    const MODE_TRANSIT   = 'transit'; 

    private $url = 'https://maps.googleapis.com/maps/api/distancematrix/';

    /**
     * 
     */
    private $key;

    /**
     * dados retornados pela api
     */
    private $data;

    /**
     * Tipo de retorno
     * 
     * padrão json
     */
    private $type = self::TYPE_JSON;

    /**
     * destinos
     * Um ou mais locais a serem usados como ponto de chegada para calcular a distância e o tempo de viagem. 
     * As opções do parâmetro destinos são as mesmas do parâmetro origens.
     */
    private $destinations;

    /**
     * O ponto de partida para calcular a distância e o tempo de viagem. 
     * Você pode fornecer um ou mais locais separados pelo caractere vertical (|), na forma de um ID de local, 
     * um endereço ou coordenadas de latitude/longitude:
     *   - ID do local: se você fornecer um ID do local, deverá prefixá-lo com place_id:.
     * 
     *   - Endereço: Se você passar um endereço, o serviço geocodifica a string e a converte em uma coordenada de latitude/longitude 
     *     para calcular a distância. Essa coordenada pode ser diferente daquela retornada pela API de geocodificação, por exemplo, 
     *     a entrada de um edifício em vez de seu centro.
     * 
     * Observação: é preferível usar IDs de locais em vez de endereços ou coordenadas de latitude/longitude. 
     * O uso de coordenadas sempre resultará no ponto sendo encaixado na estrada mais próxima a essas coordenadas 
     * - que pode não ser um ponto de acesso à propriedade ou mesmo uma estrada que levará de forma rápida ou segura ao destino. 
     * O uso do endereço fornecerá a distância até o centro do prédio, em oposição a uma entrada do prédio.
     * 
     *   - Coordenadas: Se você passar as coordenadas de latitude/longitude, elas se encaixarão na estrada mais próxima. 
     *     É preferível passar um ID de local. Se você passar coordenadas, certifique-se de que não haja espaço entre os valores de 
     *     latitude e longitude.
     *   - Os códigos plus devem ser formatados como um código global ou um código composto. Formate os códigos de adição conforme 
     *     mostrado aqui (os sinais de adição têm escape de url para %2B e os espaços têm escape de url para %20):
     *       - o código global é um código de área de 4 caracteres e um código local de 6 caracteres ou mais 
     *         (849VCWC8+R9 é codificado para 849VCWC8%2BR9).
     * 
     *       - código composto é um código local de 6 caracteres ou mais com uma localização explícita (CWC8+R9 Mountain View, CA, EUA 
     *         é codificado para CWC8%2BR9%20Mountain%20View%20CA%20USA).
     * 
     *   - Polilinha codificada Como alternativa, você pode fornecer um conjunto codificado de coordenadas usando o Algoritmo de polilinha 
     *     codificada. Isso é particularmente útil se você tiver um grande número de pontos de origem, porque a URL é significativamente 
     *     mais curta ao usar uma polilinha codificada.
     *        - Polilinhas codificadas devem ser prefixadas com enc: e seguidas por dois pontos :. Por exemplo: origins=enc:gfo}EtohhU:
     *        - Você também pode incluir várias polilinhas codificadas, separadas pela barra vertical |. Por exemplo:
     *              - origins=enc:wc~oAwquwMdlTxiKtqLyiK:|enc:c~vnAamswMvlTor@tjGi}L:|enc:udymA{~bxM:
     */
    private $origins;

    /**
     * O idioma no qual retornar os resultados.
     */
    private $language;

    /**
     * Para o cálculo de distâncias e direções, você pode especificar o modo de transporte a ser usado. Por padrão, o modo DRIVING é usado. 
     * Por padrão, as rotas são calculadas como rotas de carro. Os seguintes modos de viagem são suportados:
     * 
     * - driving (padrão) indica direções de condução padrão ou distância usando a rede rodoviária.
     * 
     * - walking solicita rotas a pé ou distância por meio de caminhos de pedestres e calçadas (quando disponíveis).
     * 
     * - bicycling solicita rotas de bicicleta ou distância por ciclovias e ruas preferidas (quando disponíveis).
     * 
     * - transit solicita direções ou distância por meio de rotas de transporte público (quando disponíveis). Se você definir o modo como 
     *   trânsito, poderá especificar opcionalmente um horário_de_partida ou um_de_chegada. Se nenhum dos horários for especificado, 
     *   o padrão da hora_de_partida é agora (ou seja, o horário de partida é padronizado como a hora atual). Você também pode opcionalmente 
     *   incluir um transit_mode e/ou um transit_routing_preference
     */
    private $mode;

    /**
     * Especifica o sistema de unidades a ser usado ao exibir resultados.
     */
    private $units;
    
    public function __construct($key, $origins, $destinations, $type = self::TYPE_JSON, $language = 'pt-BR', $mode = self::MODE_DRIVING){
        $this->key = $key;
        $this->origins = $origins;
        $this->destinations = $destinations;
        $this->type = $type;
        $this->language = $language;
        $this->mode = $mode;
    }

    public function formatUrl(){

        $url = $this->url . $this->type . '&origins=' . $this->getOrigins() . '&destinations=' . $this->getDestinations() .
        '$language=' . $this->language . '&mode=' . $this->mode;

        return $url;
    }

    public function getOrigins(){
        return urlencode($this->origins);
    }

    public function getDestinations(){
        return urlencode($this->destinations);
    }

}