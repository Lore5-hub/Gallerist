<?php
class FVisita {
    private static string $class  = 'FVisita';
    private static string $table  = 'visita';
    private static string $values = '(:id, :pagina, :data, :sessione)';
    public static function getClass(): string  { return static::$class; }
    public static function getTable(): string  { return static::$table; }
    public static function getValues(): string { return static::$values; }

    public static function bind($stmt, EVisita $visita): void {
    $stmt->bindValue(':id',       NULL,                                         PDO::PARAM_INT);
    $stmt->bindValue(':pagina',   $visita->getPagina(),                         PDO::PARAM_STR);
    $stmt->bindValue(':data',     $visita->getData()->format('Y-m-d H:i:s'),    PDO::PARAM_STR);
    $stmt->bindValue(':sessione', $visita->getSessione(),                       PDO::PARAM_STR);
}
    public static function store(EVisita $visita): ?string {
        $db = FDataBase::getInstance();
        return $db->storeDB(static::$class, $visita);
    }
}
?>