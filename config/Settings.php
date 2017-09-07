<?php

namespace wsGerProj\Config;

/**
 * Configurações gerais do sistema
 *
 * @author anderson
 */
final class Settings {
    
    /**
     * Qtd de registros por página
     */
    const RECORDS = 5;
    const LOGIN_EXPIRATION = 12000000;
    const MEMCACHE_HOST = 'localhost';
    const MEMCACHE_PORT = 11211;
    
}
