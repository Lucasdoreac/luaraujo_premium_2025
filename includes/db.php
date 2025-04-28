<?php
/**
 * Conexão com o banco de dados
 * 
 * Gerencia conexões com o banco de dados otimizadas para servidor compartilhado
 */

require_once __DIR__ . '/../config/config.php';

/**
 * Obtém uma conexão com o banco de dados
 * 
 * @return mysqli Conexão com o banco de dados
 */
function get_db_connection() {
    static $conn = null;
    
    // Reutiliza a conexão existente se possível
    if ($conn === null) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // Verifica se houve erro na conexão
        if ($conn->connect_error) {
            error_log("Erro de conexão com o banco de dados: " . $conn->connect_error);
            
            // Em ambiente de produção, mostrar erro genérico
            if (ENVIRONMENT === 'production') {
                die("Erro ao conectar ao banco de dados. Por favor, tente novamente mais tarde.");
            } else {
                die("Erro de conexão: " . $conn->connect_error);
            }
        }
        
        // Configura charset para UTF-8
        $conn->set_charset("utf8mb4");
    }
    
    return $conn;
}

/**
 * Executa uma query preparada e retorna os resultados
 * 
 * @param string $query Query SQL com placeholders para os parâmetros
 * @param string $types Tipos dos parâmetros (i: int, s: string, d: double, b: blob)
 * @param array $params Parâmetros para substituir nos placeholders
 * @return mysqli_result|bool Resultado da query ou FALSE em caso de erro
 */
function db_query($query, $types = "", $params = []) {
    $conn = get_db_connection();
    
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        error_log("Erro ao preparar query: " . $conn->error . " - Query: " . $query);
        return false;
    }
    
    // Bind parameters se existirem
    if (!empty($params) && !empty($types)) {
        $stmt->bind_param($types, ...$params);
    }
    
    // Executa a query
    if (!$stmt->execute()) {
        error_log("Erro ao executar query: " . $stmt->error . " - Query: " . $query);
        $stmt->close();
        return false;
    }
    
    $result = $stmt->get_result();
    $stmt->close();
    
    return $result;
}

/**
 * Busca um único registro do banco de dados
 * 
 * @param string $query Query SQL com placeholders para os parâmetros
 * @param string $types Tipos dos parâmetros (i: int, s: string, d: double, b: blob)
 * @param array $params Parâmetros para substituir nos placeholders
 * @return array|null Array associativo com o registro ou NULL se não encontrado
 */
function db_fetch_one($query, $types = "", $params = []) {
    $result = db_query($query, $types, $params);
    
    if (!$result) {
        return null;
    }
    
    $row = $result->fetch_assoc();
    $result->free();
    
    return $row;
}

/**
 * Busca múltiplos registros do banco de dados
 * 
 * @param string $query Query SQL com placeholders para os parâmetros
 * @param string $types Tipos dos parâmetros (i: int, s: string, d: double, b: blob)
 * @param array $params Parâmetros para substituir nos placeholders
 * @return array Array de arrays associativos com os registros
 */
function db_fetch_all($query, $types = "", $params = []) {
    $result = db_query($query, $types, $params);
    
    if (!$result) {
        return [];
    }
    
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    
    $result->free();
    
    return $rows;
}

/**
 * Insere um registro no banco de dados
 * 
 * @param string $table Nome da tabela
 * @param array $data Array associativo com dados a inserir (coluna => valor)
 * @return int|bool ID do registro inserido ou FALSE em caso de erro
 */
function db_insert($table, $data) {
    $conn = get_db_connection();
    
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));
    
    $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    
    $types = "";
    $params = [];
    
    foreach ($data as $value) {
        if (is_int($value)) {
            $types .= "i";
        } elseif (is_float($value)) {
            $types .= "d";
        } elseif (is_null($value)) {
            $types .= "s"; // NULL tratado como string
        } else {
            $types .= "s";
        }
        
        $params[] = $value;
    }
    
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        error_log("Erro ao preparar query de inserção: " . $conn->error);
        return false;
    }
    
    $stmt->bind_param($types, ...$params);
    
    if (!$stmt->execute()) {
        error_log("Erro ao executar inserção: " . $stmt->error);
        $stmt->close();
        return false;
    }
    
    $insert_id = $stmt->insert_id;
    $stmt->close();
    
    return $insert_id;
}

/**
 * Atualiza um registro no banco de dados
 * 
 * @param string $table Nome da tabela
 * @param array $data Array associativo com dados a atualizar (coluna => valor)
 * @param string $where Condição WHERE (sem o "WHERE")
 * @param string $types Tipos dos parâmetros para a condição WHERE
 * @param array $params Parâmetros para a condição WHERE
 * @return bool TRUE se atualizado com sucesso, FALSE em caso de erro
 */
function db_update($table, $data, $where, $types_where = "", $params_where = []) {
    $conn = get_db_connection();
    
    $set = [];
    $types = "";
    $params = [];
    
    foreach ($data as $column => $value) {
        $set[] = "$column = ?";
        
        if (is_int($value)) {
            $types .= "i";
        } elseif (is_float($value)) {
            $types .= "d";
        } elseif (is_null($value)) {
            $types .= "s"; // NULL tratado como string
        } else {
            $types .= "s";
        }
        
        $params[] = $value;
    }
    
    $set_clause = implode(", ", $set);
    $query = "UPDATE $table SET $set_clause WHERE $where";
    
    // Concatena tipos e parâmetros para a condição WHERE
    $types .= $types_where;
    $params = array_merge($params, $params_where);
    
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        error_log("Erro ao preparar query de atualização: " . $conn->error);
        return false;
    }
    
    $stmt->bind_param($types, ...$params);
    
    if (!$stmt->execute()) {
        error_log("Erro ao executar atualização: " . $stmt->error);
        $stmt->close();
        return false;
    }
    
    $affected_rows = $stmt->affected_rows;
    $stmt->close();
    
    return $affected_rows > 0;
}