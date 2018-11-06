<?php
    class Mensagens {
        protected $conexao;

        public function conectar(){
            $this->conexao = new PDO("mysql:host=localhost;dbname=batepapo", "root", "");
        }

        public function getTodasMensagens(){
            $comando = $this->conexao->prepare("SELECT * FROM mensagem");
            $comando->execute();
            return $comando;
        }
    public function enviar($dados){
        $comando = $this->conexao->prepare(
            "INSERT INTO mensagem (
                remetente,
                texto
            ) VALUES (
                :remetente,
                :texto
            )"
        );

        $dados = [
            ':remetente' => $dados['remetente'],
            ':texto' => $dados['texto']
        ];

        $comando->execute($dados);
        return $this->conexao->lastInsertId();
    }
    public function __construct() {
        $this->conectar();
    }
}
?>