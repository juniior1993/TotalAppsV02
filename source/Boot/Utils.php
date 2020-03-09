<?php

/**
 * ###############
 * ###   URL   ###
 * ###############
 */

/**
 * @param string $path
 * @return string
 */
function url(string $path = null): string
{
    if ($path) {
        return CONF_URL_SITE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_SITE;
}

/**
 * @param string $url
 */
function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    $location = url($url);
    header("Location: {$location}");
    exit;
}


/**
 * @param string $file
 * @return string
 */
function assets(string $file): string
{
    return CONF_URL_SITE . "/theme/assets" . $file;
}


/**
 * LOGIN
 */
function verifyLogin()
{
    $session = new \Source\Core\Session();

    if (!$session->logado) {
        $session->setFlash("Acesso restrito, por favor faça o login!", "error", 3000);
        redirect("/auth");
    }

}

/**
 * DATES
 */

/**
 * @param string $data
 * @param string $format
 * @return string
 * @throws Exception
 */
function decodeDate(string $data, string $format = "d/m/Y"): string
{
    $date = new DateTime();
    $date->setTimestamp(substr($data, 0, -3));
    return $date->format($format);
}

/*
 * CONF DATA VARIABLE
 */

function utilDataOrcamentos(array $data): array
{

    $date = new DateTime();
    $date->sub(new DateInterval('P30D'));

    $arrayFinal = [];
    (isset($data["dataIni"]) && $data["dataIni"]) ? $arrayFinal[] = $data["dataIni"] : $arrayFinal[] = $date->format('Y-m-d');
    (isset($data["dataFinal"]) && $data["dataFinal"]) ? $arrayFinal[] = $data["dataFinal"] : $arrayFinal[] = null;
    (isset($data["consultor"]) && $data["consultor"]) ? $arrayFinal[] = $data["consultor"] : $arrayFinal[] = null;
    (isset($data["aprovado"]) && $data["aprovado"]) ? $arrayFinal[] = $data["aprovado"] : $arrayFinal[] = null;
    (isset($data["valor"]) && $data["valor"]) ? $arrayFinal[] = $data["valor"] : $arrayFinal[] = null;
    (isset($data["idiomaDe"]) && $data["idiomaDe"]) ? $arrayFinal[] = $data["idiomaDe"] : $arrayFinal[] = null;
    (isset($data["idiomaPara"]) && $data["idiomaPara"]) ? $arrayFinal[] = $data["idiomaPara"] : $arrayFinal[] = null;
    (isset($data["juramentada"]) && $data["juramentada"]) ? $arrayFinal[] = $data["juramentada"] : $arrayFinal[] = null;

    return $arrayFinal;
}