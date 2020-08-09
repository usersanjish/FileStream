<?php
    class Filestr{
        public $i = 0;
        private $arr = [], $positive, $negative, $fdata, $edata, $argvFrist, $argvSecond;
        function __construct($argvFrist, $argvSecond){
           $this->argvFrist = $argvFrist;
           $this->argvSecond = $argvSecond;
        }
        private function saveValues($strw){
            $this->arr[$this->i] = $strw;
            echo $this->i.") ". $this->arr[$this->i];
            $this->positive = fopen("positive.txt", 'w') or die("He удалось создать файл");
                $this->negative = fopen("negative.txt", 'w') or die("He удалось создать файл");
                    foreach($this->arr as $key => $result){
                        if($result > 0){
                            fputs($this->positive, "$key) $result");
                        }else{
                            fputs($this->negative, "$key) $result");
                        }
                    }
                fclose($this->negative);
            fclose($this->positive);
        }
        public function getValues(){
            $this->fdata = fopen($this->argvFrist, 'r') or die("He удалось открыть файл");
                while(!feof($this->fdata)){
                    $this->i++;
                    $this->edata = explode(" " ,fgets($this->fdata));
                    switch ($this->argvSecond) {
                        case 'x':
                        $this->strw = (int)$this->edata[0] * (int)$this->edata[1]."\n";
                        $this->saveValues($this->strw);
                        break;
                        case ':':
                        $this->strw = (int)$this->edata[0] / (int)$this->edata[1]."\n";
                        $this->saveValues($this->strw);
                        break;
                        case '+':
                        $this->strw = (int)$this->edata[0] + (int)$this->edata[1]."\n";
                        $this->saveValues($this->strw);
                        break;
                        case '-':
                        $this->strw = (int)$this->edata[0] - (int)$this->edata[1]."\n";
                        $this->saveValues($this->strw);
                        break;
                    }
                }
            fclose($this->fdata);
        }
    }
    if(isset($argv) && count($argv) == 3 && preg_match_all("/[x]|[:]|[-]|[+]/",$argv[2])){
            $str = new Filestr($argv[1], $argv[2]);
            $str->getValues();
            echo 'Сохранено!';
        }else{
            echo 'Введите только два аргумента "имя файла" и "тип операции" после запускающего скрипта.';
        }
?>