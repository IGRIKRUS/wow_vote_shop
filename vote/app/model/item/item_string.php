<?php
namespace app\model\item;
if(!defined('DOST')){ die(header("HTTP/1.x 404 Not Found"));}

class item_string 
{
    public $version = 12340;
    public $getVersion;
    public $lang;


    public function __construct() {
       // $this->lang = new \libs\Lang\Language($GLOBALS['Lang']);
       // $this->lang->load('item_tooltip');
    }

    public function class_subclass($class, $sub_class) {
        if($this->getVersion <= $this->version){  
        $item_type_class_subclass[0][0] = 'Расходуемые';
        $item_type_class_subclass[0][1] = 'Зелье';
        $item_type_class_subclass[0][2] = 'Эликсир';
        $item_type_class_subclass[0][3] = 'Настой';
        $item_type_class_subclass[0][4] = 'Свиток';
        $item_type_class_subclass[0][5] = 'Предмет потребления';
        $item_type_class_subclass[0][6] = 'Улучшение';
        $item_type_class_subclass[0][7] = 'Бинты';
        $item_type_class_subclass[0][8] = ''; //null
        $item_type_class_subclass[1][0] = 'Сумка';
        $item_type_class_subclass[1][1] = 'Сумка душ';
        $item_type_class_subclass[1][2] = 'Сумка травника';
        $item_type_class_subclass[1][3] = 'Сумка зачаровывателя';
        $item_type_class_subclass[1][4] = 'Сумка инженера';
        $item_type_class_subclass[1][5] = 'Сумка ювелира';
        $item_type_class_subclass[1][6] = 'Сумка шахтера';
        $item_type_class_subclass[1][7] = 'Сумка кожевника';
        $item_type_class_subclass[1][8] = 'Сумка начертателя';
        $item_type_class_subclass[2][0] = 'Топор';
        $item_type_class_subclass[2][1] = 'Топор';
        $item_type_class_subclass[2][2] = 'Лук';
        $item_type_class_subclass[2][3] = 'Огнестрельное';
        $item_type_class_subclass[2][4] = 'Дробящее';
        $item_type_class_subclass[2][5] = 'Дробящее';
        $item_type_class_subclass[2][6] = 'Древковое';
        $item_type_class_subclass[2][7] = 'Меч';
        $item_type_class_subclass[2][8] = 'Меч';
        $item_type_class_subclass[2][9] = 'Устаревшие'; //null false
        $item_type_class_subclass[2][10] = 'Посох';
        $item_type_class_subclass[2][11] = 'Одноручное экзотическое'; //null false
        $item_type_class_subclass[2][12] = 'Двуручное экзотическое'; //null false
        $item_type_class_subclass[2][13] = 'Кистевое оружие';
        $item_type_class_subclass[2][14] = 'Разное'; //null
        $item_type_class_subclass[2][15] = 'Кинжал';
        $item_type_class_subclass[2][16] = 'Метательное';
        $item_type_class_subclass[2][17] = 'Копье'; //null false
        $item_type_class_subclass[2][18] = 'Арбалет';
        $item_type_class_subclass[2][19] = 'Жезл';
        $item_type_class_subclass[2][20] = 'Удочка';
        $item_type_class_subclass[3][0] = 'Красные'; //slot Red
        $item_type_class_subclass[3][1] = 'Синие'; //slot Blue
        $item_type_class_subclass[3][2] = 'Желтые'; //slot Yellow
        $item_type_class_subclass[3][3] = 'Фиолетовые'; //slot Purple
        $item_type_class_subclass[3][4] = 'Зеленые'; //slot Green
        $item_type_class_subclass[3][5] = 'Оранжевые'; //slot Orange
        $item_type_class_subclass[3][6] = 'Особые'; //slot Meta
        $item_type_class_subclass[3][7] = 'Простые'; //null
        $item_type_class_subclass[3][8] = 'Радужные'; //null
        $item_type_class_subclass[4][0] = 'Разное'; //null
        $item_type_class_subclass[4][1] = 'Ткань';
        $item_type_class_subclass[4][2] = 'Кожа';
        $item_type_class_subclass[4][3] = 'Кольчуга';
        $item_type_class_subclass[4][4] = 'Латы';
        $item_type_class_subclass[4][5] = 'Кулачный щит'; //null false
        $item_type_class_subclass[4][6] = 'Щит';
        $item_type_class_subclass[4][7] = 'Манускрипт';
        $item_type_class_subclass[4][8] = 'Идол';
        $item_type_class_subclass[4][9] = 'Тотем';
        $item_type_class_subclass[4][10] = 'Печать';
        $item_type_class_subclass[5][0] = 'Реагент';
        $item_type_class_subclass[6][0] = '';//'Жезл(НЕ ИСП.)'; //null false
        $item_type_class_subclass[6][1] = '';'Болт(НЕ ИСП.)'; //null false
        $item_type_class_subclass[6][2] = 'Стрелы';
        $item_type_class_subclass[6][3] = 'Пули'; //null
        $item_type_class_subclass[6][4] = 'Метательное(НЕ ИСП.)'; //null false
        $item_type_class_subclass[7][0] = 'Хозяйственные товары'; //null false
        $item_type_class_subclass[7][1] = 'Детали'; //null
        $item_type_class_subclass[7][2] = 'Взрывчатка';
        $item_type_class_subclass[7][3] = 'Устройства'; //null
        $item_type_class_subclass[7][4] = 'Ювелирное дело'; //Jewelcrafting
        $item_type_class_subclass[7][5] = 'Ткань'; //Cloth
        $item_type_class_subclass[7][6] = 'Кожа'; //Leather
        $item_type_class_subclass[7][7] = 'Металл и камень'; //Metal & Stone
        $item_type_class_subclass[7][8] = 'Мясо'; //Meat
        $item_type_class_subclass[7][9] = 'Трава'; //Herb
        $item_type_class_subclass[7][10] = 'Стихии'; //Elemental
        $item_type_class_subclass[7][11] = ''; //Other
        $item_type_class_subclass[7][12] = 'Наложение чар'; //Enchanting
        $item_type_class_subclass[7][13] = 'Другое'; //Materials
        $item_type_class_subclass[7][14] = 'Чары для оружия'; //Armor Enchantment
        $item_type_class_subclass[7][15] = 'Чары для оружия'; //Weapon Enchantment
        $item_type_class_subclass[8][0] = '';//'Стандартный(НЕ ИСП.)'; //null
        $item_type_class_subclass[9][0] = 'Книга';
        $item_type_class_subclass[9][1] = 'Кожевничество'; //Кожевничество';
        $item_type_class_subclass[9][2] = 'Портняжное дело';
        $item_type_class_subclass[9][3] = 'Инженерное дело';
        $item_type_class_subclass[9][4] = 'Кузнечное дело';
        $item_type_class_subclass[9][5] = 'Кулинария';
        $item_type_class_subclass[9][6] = 'Алхимия';
        $item_type_class_subclass[9][7] = 'Первая помощь';
        $item_type_class_subclass[9][8] = 'Наложение чар';
        $item_type_class_subclass[9][9] = 'Рыбная ловля';
        $item_type_class_subclass[9][10] = 'Ювелирное дело';
        $item_type_class_subclass[9][11] = 'Начертание';
        $item_type_class_subclass[10][0] = '';//'Деньги (НЕ ИСП.)'; //null
        $item_type_class_subclass[11][0] = '';//'Колчан (НЕ ИСП.)'; //null false
        $item_type_class_subclass[11][1] = '';//'Колчан (НЕ ИСП.)'; //null false
        $item_type_class_subclass[11][2] = 'Колчан';
        $item_type_class_subclass[11][3] = 'Подсумок';
        $item_type_class_subclass[12][0] = 'Задания'; //null
        $item_type_class_subclass[13][0] = 'Ключ';
        $item_type_class_subclass[13][1] = 'Отмычка'; //null false
        $item_type_class_subclass[14][0] = 'Постоянные'; //null false
        $item_type_class_subclass[15][0] = 'Хлам'; //null
        $item_type_class_subclass[15][1] = 'Реагент';
        $item_type_class_subclass[15][2] = 'Питомцы';
        $item_type_class_subclass[15][3] = 'Праздничный предмет';
        $item_type_class_subclass[15][4] = ''; //Другое
        $item_type_class_subclass[15][5] = 'Средство передвежения';
        $item_type_class_subclass[16][1] = 'Класс: воин'; //символ
        $item_type_class_subclass[16][2] = 'Класс: паладин'; //символ
        $item_type_class_subclass[16][3] = 'Класс: охотник'; //символ
        $item_type_class_subclass[16][4] = 'Класс: разбойник'; //символ
        $item_type_class_subclass[16][5] = 'Класс: жреца'; //символ
        $item_type_class_subclass[16][6] = 'Класс: Рыцарь смерти'; //символ
        $item_type_class_subclass[16][7] = 'Класс: Шаман'; //символ
        $item_type_class_subclass[16][8] = 'Класс: Маг'; //символ
        $item_type_class_subclass[16][9] = 'Класс: Чернокнижник'; //символ
        $item_type_class_subclass[16][11] = 'Класс: Друид'; //символ

        return $item_type_class_subclass[$class][$sub_class];
        }
    }

    public function Quality($type, $name) {
        if($this->getVersion <= $this->version){
        $Quality_color[0] = '#9d9d9d';
        $Quality_color[1] = '#fff';
        $Quality_color[2] = '#1eff00';
        $Quality_color[3] = '#0070dd';
        $Quality_color[4] = '#a335ee';
        $Quality_color[5] = '#ff8000';
        $Quality_color[6] = '#e5cc80';
        $Quality_color[7] = '#e5cc80';
        $name = '<font color="' . $Quality_color[$type] . '">' . $name . '</font>';
        }
        return $name;
    }
    
    public function InventoryType($type) {
        if ($this->getVersion <= $this->version) {
            $InventoryType[0] = '';
            $InventoryType[1] = 'Голова';
            $InventoryType[2] = 'Ожерелье';
            $InventoryType[3] = 'Плечи';
            $InventoryType[4] = 'Рубашка';
            $InventoryType[5] = 'Грудь';
            $InventoryType[6] = 'Пояс';
            $InventoryType[7] = 'Ноги';
            $InventoryType[8] = 'Ступни';
            $InventoryType[9] = 'Запястья';
            $InventoryType[10] = 'Руки';
            $InventoryType[11] = 'Кольцо';
            $InventoryType[12] = 'Аксессуар';
            $InventoryType[13] = 'Одноручное';
            $InventoryType[14] = 'Щит';
            $InventoryType[15] = 'Дальний бой';
            $InventoryType[16] = 'Плащ';
            $InventoryType[17] = 'Двуручное';
            $InventoryType[18] = 'Сумка';
            $InventoryType[19] = 'Гербовая накидка';
            $InventoryType[20] = 'Грудь';
            $InventoryType[21] = 'Правая рука';
            $InventoryType[22] = 'Левая рука';
            $InventoryType[23] = 'Левая рука';
            $InventoryType[24] = 'Боеприпасы';
            $InventoryType[25] = 'Метательное';
            $InventoryType[26] = 'Дальний бой';
            $InventoryType[27] = 'Колчан';
            $InventoryType[28] = 'Реликвия';
            return $InventoryType[$type];
        }
    }
    
    public function bonding($type) {
        if ($this->getVersion <= $this->version) {
            $item_bonding[1] = 'Становится персональным при получении';
            $item_bonding[2] = 'Становится персональным при надевании';
            $item_bonding[3] = 'Становится персональным при использовании';
            $item_bonding[4] = 'Предмет, необходимый для задания';
            if (array_key_exists($type, $item_bonding)) {
                return $item_bonding[$type];
            } else {
                return '';
            }
        }
    }

    public function stat_type($type) {
        if($this->getVersion <= $this->version){
        $stat_type[0] = ''; //null
        $stat_type[1] = ''; //null
        $stat_type[3] = 'к ловкости';
        $stat_type[4] = 'к силе';
        $stat_type[5] = 'к интелекту';
        $stat_type[6] = 'к духу';
        $stat_type[7] = 'к выносликости';
        $stat_type[12] = 'Рейтинг защиты';
        $stat_type[13] = 'Рейтинг уклонения';
        $stat_type[14] = 'Рейтинг парирования';
        $stat_type[15] = 'Рейтинг блокирования';
        $stat_type[16] = 'Рейтинг меткости';
        $stat_type[17] = 'Рейтинг меткости';
        $stat_type[18] = 'Рейтинг меткости';
        $stat_type[19] = 'Рейтинг критического удара';
        $stat_type[20] = 'Рейтинг критического удара';
        $stat_type[21] = 'Рейтинг критического удара';
        $stat_type[28] = 'Рейтинг скорости';
        $stat_type[29] = 'Рейтинг скорости';
        $stat_type[30] = 'Рейтинг скорости';
        $stat_type[31] = 'Рейтинг меткости';
        $stat_type[32] = 'Рейтинг критического удара';
        $stat_type[35] = 'Рейтинг устойчивости';
        $stat_type[36] = 'Рейтинг скорости';
        $stat_type[37] = 'Рейтинг мастерства';
        $stat_type[38] = 'Сила атаки';
        $stat_type[39] = 'Сила атаки дальнего боя';
        $stat_type[40] = 'Сила атаки зверя';
        $stat_type[43] = 'Скорость восстановления маны';
        $stat_type[44] = 'Рейтинг пробивания брони';
        $stat_type[45] = 'Сила заклинаний';
        $stat_type[46] = 'Восстанавливает здоровье';
        $stat_type[47] = ''; //null = 0
        $stat_type[48] = ''; //null = 0
        if (array_key_exists($type, $stat_type)) {
            return $stat_type[$type];
        } else {
            return '';
        }
        }
    }
    
    public function dmg_type($type) {
        if($this->getVersion <= $this->version){
        $dmg_type[0] = '';
        $dmg_type[1] = ' (Священный)';
        $dmg_type[2] = ' (Огненный)';
        $dmg_type[3] = ' (Природный)';
        $dmg_type[4] = ' (Ледяной)';
        $dmg_type[5] = ' (Тёмный)';
        $dmg_type[6] = ' (Тайный)';
        return $dmg_type[$type];
        }
    }

    public function res($int, $key) {
        if($this->getVersion <= $this->version){
        $item_res[0] = $int . ' к сопротивлению магии света';
        $item_res[1] = $int . ' к сопротивлению магии огня';
        $item_res[2] = $int . ' к сопротивлению сил природы';
        $item_res[3] = $int . ' к сопротивлению магии льда';
        $item_res[4] = $int . ' к сопротивлению темной магии';
        $item_res[5] = $int . ' к сопротивлению тайной магии';
        if (array_key_exists($key, $item_res)) {
            return $item_res[$key];
        } else {
            return '';
        }
        }
    }
    
    public function flags($key) {
        if($this->getVersion <= $this->version){
        $flag[8] = '<font color="#1eff00">Героический</font>';

        if (array_key_exists($key, $flag)) {
            return $flag[$key];
        } else {
            return '';
        }
        }
    }

    public function unique($type = 0) {
        if($this->getVersion <= $this->version){
        $str = '';
        if ($type == 1)
            $str = '<font color="#fff">Уникальный</font>';
        if ($type > 1)
            $str = '<font color="#fff">Уникальный("' . $type . '")</font>';
        return $str;
        }
    }
    
    public function AllowableClass($type = '') {
        if($this->getVersion <= $this->version){
        if ($type != '-1') {
            $class = '';
            if (($type & 1) == '1')
                $class .= '<font color="#C69B6D">Воин </font>  ';
            else
                $class .= '';
            if (($type & 2) == '2')
                $class .= '<font color="#F48CBA">Паладин </font>  ';
            else
                $class .= '';
            if (($type & 4) == '4')
                $class .= '<font color="#AAD372">Охотник </font>  ';
            else
                $class .= '';
            if (($type & 8) == '8')
                $class .= '<font color="#FFF468">Разбойник </font>  ';
            else
                $class .= '';
            if (($type & 16) == '16')
                $class .= '<font color="#FFF">Жрец </font>  ';
            else
                $class .= '';
            if (($type & 32) == '32')
                $class .= '<font color="#C41E3B">Рыцарь смерти </font>  ';
            else
                $class .= '';
            if (($type & 64) == '64')
                $class .= '<font color="#2359FF">Шаман </font>  ';
            else
                $class .= '';
            if (($type & 128) == '128')
                $class .= '<font color="#68CCEF">Маг </font>  ';
            else
                $class .= '';
            if (($type & 256) == '256')
                $class .= '<font color="#9382C9">Чернокнижник </font>  ';
            else
                $class .= '';
            if (($type & 1024) == '1024')
                $class .= '<font color="#FF7C0A">Друид </font>  ';
            else
                $class .= '';
            $class = str_replace('  ', ',', $class);
            $class = substr($class, 0, strlen($class) - 1);
            $cl = explode(',', $class);
            if (count($cl) != '10') {
                $all = "Классы: $class";
                return $all;
            }
            }
        }
    }
    
    public function AllowableRace($type = '') {
        // ?????
        if($this->getVersion <= $this->version){
        $race = '';
        if ($type != '-1') {
            if (($type & 1) == '1')
                $race .= 'Человек  ';
            else
                $race .= '';
            if (($type & 2) == '2')
                $race .= 'Орк  ';
            else
                $race .= '';
            if (($type & 4) == '4')
                $race .= 'Дворф  ';
            else
                $race .= '';
            if (($type & 8) == '8')
                $race .= 'Ночтой эльф  ';
            else
                $race .= '';
            if (($type & 16) == '16')
                $race .= 'Нежить  ';
            else
                $race .= '';
            if (($type & 32) == '32')
                $race .= 'Таурен  ';
            else
                $race .= '';
            if (($type & 64) == '64')
                $race .= 'Гном  ';
            else
                $race .= '';
            if (($type & 128) == '128')
                $race .= 'Тролль  ';
            else
                $race .= '';
            if (($type & 256) == '256')
                $race .= 'Эльф крови  ';
            else
                $race .= '';
            if (($type & 1024) == '1024')
                $race .= 'Дреней  ';
            else
                $race .= '';
            $race = str_replace('  ', ',', $race);
            $race = substr($race, 0, strlen($race) - 1);
            $rc = explode(',', $race);
            if (count($rc) != '10') {
                $all = "Расы: $race";
                return $all;
            }
          }
        }
    }
    
    public function item_soket($type) {
        if($this->getVersion <= $this->version){
        $item_socket[1] = '<div style="background: url(http://wowimg.zamimg.com/images/icons/socket-meta.gif) no-repeat 1px; color: #9d9d9d;padding-left: 20px;">особое гнездо</div>';
        $item_socket[2] = '<div style="background: url(http://wowimg.zamimg.com/images/icons//socket-red.gif) no-repeat 1px; color: #9d9d9d;padding-left: 20px;">красное гнездо</div>';
        $item_socket[4] = '<div style="background: url(http://wowimg.zamimg.com/images/icons/socket-yellow.gif) no-repeat 1px; color: #9d9d9d;padding-left: 20px;">желтое гнездо</div>';
        $item_socket[8] = '<div style="background: url(http://wowimg.zamimg.com/images/icons/socket-blue.gif) no-repeat 1px; color: #9d9d9d;padding-left: 20px;">синее гнездо</div>';
        if (array_key_exists($type, $item_socket)) {
            return $item_socket[$type];
        } else {
            return '';
        }
        }
    }

    public function speed($daley) {
        $speed = $daley / 1000; 
        if (is_float($speed)) {
            $speed .= '0';
        } else {
            $speed .= '.00';
        }
        return $speed;
    }

    public function dmg_sec($min, $max, $speed) {
        if ($speed == 0) {
            $speed = 1000;
        }
        return round(($min + $max) / ($speed / 1000) / 2, 1);
    }

    public function item_money($money) {
        $gold = (int) substr($money, 0, -4);
        $silver = floor((int) substr($money, -4, 4) / 100);
        $med = (int) substr($money, -2);
        $man = '';
        if ($gold >= 1 and $gold != 0) {
            $man[0] = '<span class="moneygold" >' . $gold . '</span>';
        }
        if ($silver <= 99 and $silver != 0) {
            $man[1] = '<span class="moneysilver" >' . $silver . '</span>';
        }
        if ($med <= 99 and $med != 0) {
            $man[2] = '<span class="moneycopper">' . $med . '</span>';
        }
        if (is_array($man)) {
            $mn = implode(' ', $man);
            return $mn;
        }
    }

    public function spelltrigger($type) {
        if($this->getVersion <= $this->version){
        $spell_trigger[0] = 'Использование:';
        $spell_trigger[1] = 'Если на персонаже:';
        $spell_trigger[2] = 'Если на персонаже:';
        $spell_trigger[3] = '';
        $spell_trigger[4] = '';
        $spell_trigger[5] = '';
        $spell_trigger[6] = '';
        return $spell_trigger[$type];
        }
    }
    
    
    public function fraction_rank($type) {
        if($this->getVersion <= $this->version){
        $faction_rank[0] = 'Ненависть';
        $faction_rank[1] = 'Враждебность';
        $faction_rank[2] = 'Неприязнь';
        $faction_rank[3] = 'Равнодушие';
        $faction_rank[4] = 'Дружелюбие';
        $faction_rank[5] = 'Уважение';
        $faction_rank[6] = 'Почтение';
        $faction_rank[7] = 'Превознесение';
        return $faction_rank[$type];
        }
    }
    
}
