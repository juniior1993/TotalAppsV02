<?php


namespace Source\App;

use CoffeeCode\Router\Router;
use DateInterval;
use DateTime;
use League\Plates\Engine;
use Source\Core\Password;
use Source\Core\Session;
use Source\Models\Comercial;
use Source\Models\JsonGenerators;
use Source\Models\ListOrcamentos;
use Source\Models\User;

class Web
{

    private Engine $view;

    private Router $router;

    private Session $session;

    private ?\CoffeeCode\DataLayer\DataLayer $user;


    public function __construct($router)
    {
        $this->view = Engine::create(__DIR__ . '/../../theme/pages', "php");

        $this->view->addData(["router" => $router]);
        $this->router = $router;

        $this->session = new Session();

        $user = (new User())->findById($this->session->logado ?? 0);

        if ($user) {
            $this->view->addData(["user" => $user]);
            $this->user = $user;
        }


    }

    public function home(array $data): void
    {
        echo $this->view->render("home", [
            "title" => "TotalApps | Home"
        ]);
    }

    public function testeOrcamento(array $data): void
    {
        $date = new DateTime();
        $date->sub(new DateInterval('P30D'));
        $comercial = new Comercial();
        $comercial->findByCustomParameters($date->format('Y-m-d'));
        $orcamentos = $comercial->findAll()->limit(10)->order("COM_DataCadastro DESC")->fetch(true);

        echo $this->view->render("paginaTeste", [
            "title" => "TotalApps | Home",
            "teste" => $orcamentos,
            "dataInicial" => $date->format('d/m/Y')
        ]);
    }


    public function addUser(array $data): void
    {

        $user = (new User())->newUser("Darci", "Junior", "juniior1993@gmail.com", "123456");

        var_dump($user->save());
        var_dump($user);

    }

    /**
     * AUTH
     */
    public function login(array $data): void
    {
        if ($this->session->logado) {
            redirect("/");
        } else {
            echo $this->view->render("login", [
                "title" => "TotalApps | Login"
            ]);
        }
    }

    public function authenticate(array $data): void
    {
        $user = (new User())->find("email=:email", "email={$data['email']}")->fetch();

        if (!$user) {
            $response['messages'][] = ["message" => "Email ou senha não conferem, tente novamente", "type" => "error"];
            echo json_encode($response);
            return;
        }
        $response['verify'] = (new Password($data['password']))->verify($user->password);

        if (!$response['verify']) {
            $response['messages'][] = ["message" => "Email ou senha não conferem, tente novamente", "type" => "error"];
        } else {
            $response['messages'][] = ["message" => "Login efetuado com sucesso!", "type" => "success"];
            $response['messages'][] = ["message" => "Bem Vindo {$user->first_name} !", "type" => "success"];
            $response['redirect'] = ["url" => $this->router->route("web.home")];
        }

        $this->session->set("logado", $user->id);

        echo json_encode($response);
    }

    public function logoff(array $data): void
    {
        $this->session->destroy();
        $response['messages'][] = ["message" => "Logoff efetuado!", "type" => "success"];
        $response['messages'][] = ["message" => "Volte em breve!", "type" => "success"];
        $response['redirect'] = ["url" => $this->router->route("web.login")];

        echo json_encode($response);
    }


    /**
     * RELATORIOS
     */
    public function budgetReport(array $data): void
    {
        $date = new DateTime();
        $comercial = new Comercial();


        $date->sub(new DateInterval('P30D'));

        $comercial->findByCustomParameters($date->format('Y-m-d'));
        $listOrcamento = new ListOrcamentos(
            $comercial->findAll()->limit(10)->order("COM_DataCadastro DESC")->fetch(true)
        );

        echo $this->view->render("relatorio.orcamentos", [
            "title" => "TotalApps | Relátorio de Orçamentos",
            "listOrcamentos" => $listOrcamento,
            "dataInicial" => $date->format('d/m/Y')
        ]);
    }


    /**
     * END POINTS RELATORIOS
     */

    /**
     * @param array $data
     */
    public function chatsOrcamentos(array $data): void
    {
        $comercial = new Comercial();

        $parametros = utilDataOrcamentos($data);

        $comercial->findByCustomParameters(...$parametros);


        $listOrcamento = new ListOrcamentos(
            $comercial->findAll()->order("COM_DataCadastro DESC")->fetch(true)
        );



        if ($listOrcamento) {
            $result["statusComercial"] = $listOrcamento->resumoStatusComercial();


            echo json_encode($result);
        } else {
            echo json_encode(["message" => "Falha ao carregar dados"]);
        }

    }


    /**
     * FLASH SECTION
     */


    /**
     * @return void |null
     */
    public function hasFlash(): void
    {
        if ($this->session->has("flash")) {
            $flash = $this->session->flash;
            $this->session->unset("flash");

            $response['messages'][] = ["message" => $flash->message, "type" => $flash->type];

            echo json_encode($response);
            exit;
        }
        echo json_encode(["message" => ""]);
    }


    public function error(array $data)
    {
        var_dump($data);
    }
}
