<?php
/**
 * BX Dependency Resolver Exception-Hierarchie
 * 
 * Diese Exception-Hierarchie ermöglicht granulares Fehler-Handling für verschiedene
 * Arten von Dependency-Problemen. Alle Exceptions erben von BxDependencyException
 * und bieten zusätzliche Context-Informationen für detaillierte Fehleranalyse.
 * 
 * @package BX_Tools
 * @subpackage DependencyManagement
 * @since 1.0
 */

/**
 * Base Exception für alle Dependency Resolver Exceptions
 * 
 * Bietet einen Context-Array für zusätzliche Debug-Informationen.
 * Alle spezialisierten Exceptions sollten von dieser Klasse erben.
 * 
 * @package BX_Tools
 * @since 1.0
 */
class BxDependencyException extends Exception {
    /**
     * Zusätzliche Context-Informationen zum Fehler
     * @var array
     */
    protected $context = [];
    
    /**
     * Konstruktor
     * 
     * @param string $message Fehlermeldung
     * @param int $code Fehlercode (Standard: 0)
     * @param Throwable|null $previous Vorherige Exception (für Exception-Chaining)
     * @param array $context Zusätzliche Context-Daten für Debugging
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null, array $context = []) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }
    
    /**
     * Liefert Context-Informationen zum Fehler
     * 
     * @return array Assoziatives Array mit Debug-Informationen
     */
    public function getContext() {
        return $this->context;
    }
}

/**
 * Exception für kritische Major-Version-Konflikte
 * 
 * Wird geworfen wenn zwei Projekte inkompatible Major-Versionen desselben
 * Packages benötigen (z.B. guzzle 6.x vs 7.x). Diese Konflikte können
 * NICHT automatisch aufgelöst werden und erfordern manuelle Intervention.
 * 
 * Beispiel:
 * - Projekt A benötigt guzzlehttp/guzzle ^6.0
 * - Projekt B benötigt guzzlehttp/guzzle ^7.0
 * - Konflikt: Major-Versionen 6 vs 7 sind inkompatibel
 * 
 * @package BX_Tools
 * @since 1.0
 */
class BxMajorVersionConflictException extends BxDependencyException {
    /** @var string Package-Name */
    protected $package;
    /** @var string Bereits geladene Version */
    protected $loadedVersion;
    /** @var string Benötigte Version */
    protected $requiredVersion;
    /** @var string Projekt das die geladene Version nutzt */
    protected $loadedBy;
    /** @var string Projekt das die andere Version benötigt */
    protected $requiredBy;
    
    /**
     * Konstruktor
     * 
     * @param string $message Fehlermeldung
     * @param string $package Package-Name
     * @param string $loadedVersion Bereits geladene Version
     * @param string $requiredVersion Geforderte Version
     * @param string $loadedBy Projekt mit geladener Version
     * @param string $requiredBy Projekt das andere Version benötigt
     */
    public function __construct($message, $package, $loadedVersion, $requiredVersion, $loadedBy, $requiredBy) {
        $this->package = $package;
        $this->loadedVersion = $loadedVersion;
        $this->requiredVersion = $requiredVersion;
        $this->loadedBy = $loadedBy;
        $this->requiredBy = $requiredBy;
        
        parent::__construct($message, 0, null, [
            'package' => $package,
            'loaded_version' => $loadedVersion,
            'required_version' => $requiredVersion,
            'loaded_by' => $loadedBy,
            'required_by' => $requiredBy
        ]);
    }
    
    /** @return string Package-Name */
    public function getPackage() { return $this->package; }
    /** @return string Geladene Version */
    public function getLoadedVersion() { return $this->loadedVersion; }
    /** @return string Benötigte Version */
    public function getRequiredVersion() { return $this->requiredVersion; }
    /** @return string Projekt mit geladener Version */
    public function getLoadedBy() { return $this->loadedBy; }
    /** @return string Projekt das andere Version benötigt */
    public function getRequiredBy() { return $this->requiredBy; }
}

/**
 * Exception für Version-Downgrade-Versuche
 * 
 * Wird geworfen wenn ein Projekt eine niedrigere Package-Version benötigt
 * als bereits geladen ist und allow_downgrade=false gesetzt ist.
 * 
 * Beispiel:
 * - Projekt A lädt guzzle 7.8.0
 * - Projekt B benötigt guzzle 7.5.0
 * - Bei allow_downgrade=false wird diese Exception geworfen
 * 
 * @package BX_Tools
 * @since 1.0
 */
class BxVersionDowngradeException extends BxDependencyException {
    /** @var string Package-Name */
    protected $package;
    /** @var string Bereits geladene (höhere) Version */
    protected $loadedVersion;
    /** @var string Benötigte (niedrigere) Version */
    protected $requiredVersion;
    /** @var string Projekt mit geladener Version */
    protected $loadedBy;
    /** @var string Projekt das Downgrade benötigt */
    protected $requiredBy;
    
    /**
     * Konstruktor
     * 
     * @param string $message Fehlermeldung
     * @param string $package Package-Name
     * @param string $loadedVersion Geladene (höhere) Version
     * @param string $requiredVersion Geforderte (niedrigere) Version
     * @param string $loadedBy Projekt mit höherer Version
     * @param string $requiredBy Projekt das niedrigere Version benötigt
     */
    public function __construct($message, $package, $loadedVersion, $requiredVersion, $loadedBy, $requiredBy) {
        $this->package = $package;
        $this->loadedVersion = $loadedVersion;
        $this->requiredVersion = $requiredVersion;
        $this->loadedBy = $loadedBy;
        $this->requiredBy = $requiredBy;
        
        parent::__construct($message, 0, null, [
            'package' => $package,
            'loaded_version' => $loadedVersion,
            'required_version' => $requiredVersion,
            'loaded_by' => $loadedBy,
            'required_by' => $requiredBy
        ]);
    }
    
    /** @return string Package-Name */
    public function getPackage() { return $this->package; }
    /** @return string Geladene (höhere) Version */
    public function getLoadedVersion() { return $this->loadedVersion; }
    /** @return string Geforderte (niedrigere) Version */
    public function getRequiredVersion() { return $this->requiredVersion; }
    /** @return string Projekt mit höherer Version */
    public function getLoadedBy() { return $this->loadedBy; }
    /** @return string Projekt das Downgrade benötigt */
    public function getRequiredBy() { return $this->requiredBy; }
}

/**
 * Exception wenn ein Projekt nicht gefunden wird
 * 
 * Wird geworfen wenn der Projekt-Ordner nicht existiert oder
 * keine composer.lock Datei gefunden werden kann.
 * 
 * @package BX_Tools
 * @since 1.0
 */
class BxProjectNotFoundException extends BxDependencyException {
    /** @var string Projekt-Name */
    protected $projectName;
    /** @var string Projekt-Pfad */
    protected $projectPath;
    
    /**
     * Konstruktor
     * 
     * @param string $message Fehlermeldung
     * @param string $projectName Projekt-Name
     * @param string $projectPath Projekt-Pfad (optional)
     */
    public function __construct($message, $projectName, $projectPath = '') {
        $this->projectName = $projectName;
        $this->projectPath = $projectPath;
        
        parent::__construct($message, 0, null, [
            'project_name' => $projectName,
            'project_path' => $projectPath
        ]);
    }
    
    /** @return string Projekt-Name */
    public function getProjectName() { return $this->projectName; }
    /** @return string Projekt-Pfad */
    public function getProjectPath() { return $this->projectPath; }
}

/**
 * Exception wenn Composer-Autoloader nicht gefunden wird
 * 
 * Wird geworfen wenn vendor/autoload.php in einem Projekt fehlt.
 * Dies deutet darauf hin dass 'composer install' noch nicht ausgeführt wurde.
 * 
 * @package BX_Tools
 * @since 1.0
 */
class BxAutoloaderNotFoundException extends BxDependencyException {
    /** @var string Projekt-Name */
    protected $projectName;
    /** @var string Autoloader-Pfad */
    protected $autoloaderPath;
    
    /**
     * Konstruktor
     * 
     * @param string $message Fehlermeldung
     * @param string $projectName Projekt-Name
     * @param string $autoloaderPath Erwarteter Pfad zu autoload.php
     */
    public function __construct($message, $projectName, $autoloaderPath) {
        $this->projectName = $projectName;
        $this->autoloaderPath = $autoloaderPath;
        
        parent::__construct($message, 0, null, [
            'project_name' => $projectName,
            'autoloader_path' => $autoloaderPath
        ]);
    }
    
    /** @return string Projekt-Name */
    public function getProjectName() { return $this->projectName; }
    /** @return string Autoloader-Pfad */
    public function getAutoloaderPath() { return $this->autoloaderPath; }
}

/**
 * Exception wenn ein Package nicht gefunden wird
 * 
 * Wird geworfen wenn ein bestimmtes Package in keinem der
 * verfügbaren Projekte installiert ist.
 * 
 * @package BX_Tools
 * @since 1.0
 */
class BxPackageNotFoundException extends BxDependencyException {
    /** @var string Package-Name */
    protected $packageName;
    
    /**
     * Konstruktor
     * 
     * @param string $message Fehlermeldung
     * @param string $packageName Package-Name (z.B. 'guzzlehttp/guzzle')
     */
    public function __construct($message, $packageName) {
        $this->packageName = $packageName;
        
        parent::__construct($message, 0, null, [
            'package_name' => $packageName
        ]);
    }
    
    /** @return string Package-Name */
    public function getPackageName() { return $this->packageName; }
}

/**
 * Exception für ungültigen Projekt-Namen
 * 
 * Wird geworfen wenn ein Projekt-Name ungültige Zeichen enthält
 * oder nicht den Validierungs-Regeln entspricht.
 * 
 * Erlaubte Zeichen: a-z, A-Z, 0-9, Unterstrich (_), Bindestrich (-)
 * 
 * @package BX_Tools
 * @since 1.0
 */
class BxInvalidProjectNameException extends BxDependencyException {
    /** @var string Ungültiger Projekt-Name */
    protected $projectName;
    /** @var string Grund der Ablehnung */
    protected $reason;
    
    /**
     * Konstruktor
     * 
     * @param string $message Fehlermeldung
     * @param string $projectName Ungültiger Projekt-Name
     * @param string $reason Grund der Ablehnung (z.B. 'invalid_characters')
     */
    public function __construct($message, $projectName, $reason = '') {
        $this->projectName = $projectName;
        $this->reason = $reason;
        
        parent::__construct($message, 0, null, [
            'project_name' => $projectName,
            'reason' => $reason
        ]);
    }
    
    /** @return string Ungültiger Projekt-Name */
    public function getProjectName() { return $this->projectName; }
    /** @return string Grund der Ablehnung */
    public function getReason() { return $this->reason; }
}

/**
 * Exception für Security-Angriffe
 * 
 * Wird geworfen bei Sicherheits-relevanten Problemen wie:
 * - Path-Traversal-Versuche (../ in Projekt-Namen)
 * - Directory-Separator-Injection (\ oder / in Namen)
 * - SQL-Injection-Versuche
 * 
 * Enthält zusätzliche Informationen wie IP-Adresse und Timestamp
 * für Security-Audits.
 * 
 * @package BX_Tools
 * @since 1.0
 */
class BxSecurityException extends BxDependencyException {
    /** @var string Art des Angriffs (z.B. 'path_traversal', 'directory_separator') */
    protected $attackType;
    /** @var string Versuchter Wert */
    protected $attemptedValue;
    
    /**
     * Konstruktor
     * 
     * @param string $message Fehlermeldung
     * @param string $attackType Art des Angriffs
     * @param string $attemptedValue Versuchter bösartiger Wert
     */
    public function __construct($message, $attackType = 'unknown', $attemptedValue = '') {
        $this->attackType = $attackType;
        $this->attemptedValue = $attemptedValue;
        
        parent::__construct($message, 0, null, [
            'attack_type' => $attackType,
            'attempted_value' => $attemptedValue,
            'timestamp' => time(),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
    }
    
    /** @return string Art des Angriffs */
    public function getAttackType() { return $this->attackType; }
    /** @return string Versuchter Wert */
    public function getAttemptedValue() { return $this->attemptedValue; }
}

/**
 * BX Dependency Resolver - Intelligente Verwaltung isolierter Composer-Bibliotheken
 * 
 * Diese Klasse ermöglicht das automatische Laden und Verwalten von Composer-Bibliotheken
 * aus isolierten Projekt-Ordnern. Sie löst Versions-Konflikte automatisch auf, indem
 * sie die jeweils höchste verfügbare Version eines Packages lädt, wenn mehrere Projekte
 * dieselbe Abhängigkeit mit unterschiedlichen Versionen benötigen.
 * 
 * Kernfunktionalität:
 * - Lädt Composer-Projekte aus isolierten Verzeichnissen (kein globales vendor/)
 * - Analysiert alle installierten Packages über composer.lock Dateien
 * - Erstellt eine zentrale Registry aller verfügbaren Packages mit Versions-Informationen
 * - Optimiert automatisch die Lade-Reihenfolge bei mehreren Projekten
 * - Erkennt und löst Versions-Konflikte (nutzt höchste kompatible Version)
 * - Prüft transitive Dependencies automatisch (alle Sub-Dependencies in composer.lock)
 * - Validiert Composer-Constraints (^, ~, >=, etc.) für tiefere Kompatibilitätsprüfung
 * - Warnt bei Major-Version-Mismatches im Debug-Modus
 * - Cached die Registry für optimale Performance (1 Stunde TTL, JSON-Format)
 * - Unterstützt Debug-Modus für detaillierte Lade-Informationen
 * - Erstellt Dependency-Graphen für Visualisierung und Analyse
 * - Sicher gegen PHP Object Injection (JSON statt serialize)
 * 
 * Verzeichnisstruktur:
 * ```
 * /includes/external/bx_composer_libs/     ← Basis-Verzeichnis für alle Projekte
 *   /projekt_name/                         ← Ein isoliertes Composer-Projekt
 *     /vendor/                             ← Standard Composer vendor/ Verzeichnis
 *       /autoload.php                      ← Composer Autoloader
 *     composer.json                        ← Projekt-Abhängigkeiten
 *     composer.lock                        ← Installierte Versionen (wichtig!)
 * 
 * /cache/bx_dependency_resolver/           ← Cache-Verzeichnis (automatisch erstellt)
 *   registry.cache                         ← Gecachte Package-Registry
 * ```
 * 
 * Grundlegende Verwendung:
 * ```php
 * // Einzelnes Projekt laden
 * require_once DIR_FS_CATALOG . 'includes/classes/bx_dependency_resolver.php';
 * bx_dependency_resolver::require('modified_barcode');
 * 
 * // Mehrere Projekte mit automatischer Optimierung laden (empfohlen)
 * $result = bx_dependency_resolver::requireMultiple([
 *     'modified_qrcode',
 *     'modified_tcpdf',
 *     'modified_barcode'
 * ]);
 * 
 * // Debug-Modus aktivieren
 * define('BX_DEPENDENCY_DEBUG', true);
 * 
 * // Cache nach composer install/update invalidieren
 * bx_dependency_resolver::clearCache();
 * ```
 * 
 * Version-Konflikt Beispiel:
 * Wenn Projekt A guzzlehttp/guzzle 7.5 benötigt und Projekt B Version 7.8,
 * wird automatisch Version 7.8 geladen und von beiden Projekten genutzt.
 * 
 * Vorteile gegenüber globalem vendor/:
 * - Komplette Isolation zwischen verschiedenen Modulen
 * - Kein Risiko von Namespace-Kollisionen
 * - Einfachere Updates einzelner Module
 * - Automatische Version-Resolution zur Laufzeit
 * - Bessere Wartbarkeit und Modularität
 * 
 * @package    BX_Tools
 * @subpackage DependencyManagement
 * @version    1.0
 * @author     benax
 * @license    GPL
 * @link       https://www.modified-shop.org
 * @since      2026-01-23
 */

class bx_dependency_resolver {
    
    /**
     * Base-Pfad zu allen Composer-Bibliotheken
     */
    private static $base_path = null;
    
    /**
     * Cache-Pfad
     */
    private static $cache_path = null;
    
    /**
     * Log-Pfad
     */
    private static $log_path = null;
    
    /**
     * Cache-Lifetime in Sekunden (Standard: 1 Stunde)
     */
    private static $cache_lifetime = 3600;
    
    /**
     * Log-Rotation: Maximale Dateigröße in Bytes (Standard: 10MB)
     */
    private static $log_max_size = 10485760; // 10 * 1024 * 1024
    
    /**
     * Log-Rotation: Maximales Alter von Backup-Logs in Sekunden (Standard: 30 Tage)
     */
    private static $log_backup_retention = 2592000; // 30 * 24 * 3600
    
    /**
     * Bereits geladene Projekte
     */
    private static $loaded_projects = [];
    
    /**
     * Package-Registry (Package-Name => Projekt-Info)
     */
    private static $package_registry = null;
    
    /**
     * Project-Index für O(1) Lookup (Projekt-Name => Packages)
     * Performance-Optimierung: Verhindert O(n²) Lookup in getProjectPackages()
     */
    private static $project_index = null;
    
    /**
     * Debug-Modus
     */
    private static $debug = false;
    
    /**
     * Erkennt automatisch ob Production-Environment (für BX_DEPENDENCY_PRODUCTION)
     * 
     * Diese Methode wird automatisch von init() aufgerufen wenn die Konstante
     * BX_DEPENDENCY_PRODUCTION nicht manuell definiert wurde.
     * 
     * Erkennungs-Logik (Safe-by-Default):
     * 1. Development-Indikatoren (return false):
     *    - Domain: localhost, 127.0.0.1, *.local, *.test, *.dev
     *    - IP-Ranges: 192.168.x.x, 10.x.x.x (private networks)
     *    - HTTP (nicht HTTPS)
     * 
     * 2. Production-Indikatoren (return true):
     *    - HTTPS aktiviert
     *    - Öffentliche Domain ohne Dev-Keywords
     *    - Default wenn unsicher (safer)
     * 
     * Warum Safe-by-Default?
     * Im Zweifel Production-Mode aktivieren - besser ein geloggter Fehler
     * im Development als ein Checkout-Crash im Live-Shop.
     * 
     * Manuelle Override-Möglichkeit:
     * ```php
     * // Vor erstem require() definieren:
     * define('BX_DEPENDENCY_PRODUCTION', false); // Force Development
     * define('BX_DEPENDENCY_PRODUCTION', true);  // Force Production
     * ```
     * 
     * Beispiele:
     * - localhost → Development (Exceptions bei Konflikten)
     * - shop.local → Development
     * - 192.168.1.100 → Development  
     * - https://www.meinshop.de → Production (Logging statt Exceptions)
     * - http://staging.meinshop.de → Production (HTTP, aber öffentlich)
     * 
     * @return bool True = Production-Mode (Logging), False = Development-Mode (Exceptions)
     * @since 1.0
     * @see init() Ruft diese Methode automatisch auf
     * @see checkConflict() Nutzt BX_DEPENDENCY_PRODUCTION für Fehler-Handling
     */
    private static function detectProductionEnvironment() {
        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'unknown';
        $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
                 || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
        
        // Development-Domains
        $dev_patterns = [
            '/^localhost$/i',
            '/^127\.0\.0\.1$/',
            '/^::1$/',                      // IPv6 localhost
            '/\.local$/i',                   // *.local
            '/\.test$/i',                    // *.test
            '/\.dev$/i',                     // *.dev
            '/^192\.168\.\d+\.\d+$/',       // 192.168.x.x
            '/^10\.\d+\.\d+\.\d+$/',        // 10.x.x.x
            '/^172\.(1[6-9]|2[0-9]|3[0-1])\.\d+\.\d+$/' // 172.16-31.x.x
        ];
        
        foreach ($dev_patterns as $pattern) {
            if (preg_match($pattern, $host)) {
                return false; // Development
            }
        }
        
        // HTTP ohne HTTPS = vermutlich Development
        // (Moderne Production-Shops sollten HTTPS haben)
        if (!$is_https) {
            // Aber: Public domains auch ohne HTTPS als Production behandeln
            // (Legacy-Shops, Fehler-Logs sind besser als Crashes)
            // → Nur bei localhost/IPs als Dev behandelt (wurde oben schon geprüft)
        }
        
        // Default: Production (safe-by-default)
        return true;
    }
    
    /**
     * Initialisiert statische Klassen-Variablen und Cache-Verzeichnis
     * 
     * Diese Methode wird automatisch von allen öffentlichen Methoden aufgerufen
     * und sorgt für die korrekte Initialisierung der Pfade und Konfiguration.
     * 
     * Funktionsweise:
     * - Setzt $base_path zum bx_composer_libs/ Verzeichnis
     * - Setzt $cache_path zum Cache-Verzeichnis
     * - Aktiviert Debug-Modus wenn BX_DEPENDENCY_DEBUG definiert
     * - Erstellt Cache-Verzeichnis falls nicht vorhanden
     * 
     * Die Methode nutzt DIR_FS_CATALOG falls definiert (modified-shop),
     * sonst relative Pfade für Standalone-Verwendung.
     * 
     * @return void
     * @since 1.0
     */
    private static function init() {
        if (self::$base_path === null) {
            self::$base_path = defined('DIR_FS_CATALOG') 
                ? DIR_FS_CATALOG . 'includes/external/bx_composer_libs/'
                : dirname(__FILE__) . '/../../external/bx_composer_libs/';
            
            self::$cache_path = defined('DIR_FS_CATALOG')
                ? DIR_FS_CATALOG . 'cache/bx_dependency_resolver/'
                : dirname(__FILE__) . '/../../cache/bx_dependency_resolver/';
            
            self::$log_path = self::$cache_path . 'dependency_resolver.log';
            
            // Debug-Modus aus Datenbank-Konfiguration laden
            if (defined('MODULE_BX_DEPENDENCY_DEBUG')) {
                self::$debug = MODULE_BX_DEPENDENCY_DEBUG === 'true';
            } else {
                self::$debug = false;
            }
            
            // Auto-Detection: Production-Mode wenn nicht manuell definiert
            if (!defined('BX_DEPENDENCY_PRODUCTION')) {
                $is_production = self::detectProductionEnvironment();
                define('BX_DEPENDENCY_PRODUCTION', $is_production);
                
                if (self::$debug) {
                    self::debug("Auto-detected environment: " . ($is_production ? "PRODUCTION" : "DEVELOPMENT"));
                }
            }
            
            // Cache-Verzeichnis erstellen
            if (!is_dir(self::$cache_path)) {
                mkdir(self::$cache_path, 0755, true);
            }
        }
    }
    
    /**
     * Lädt mehrere Projekte mit automatischer Optimierung und Version-Auflösung
     * 
     * Die Methode lädt mehrere Composer-Projekte gleichzeitig.
     * Sie analysiert alle angeforderten Projekte, ermittelt deren Abhängigkeiten und 
     * optimiert die Lade-Reihenfolge basierend auf den Versionen der gemeinsamen Packages.
     * 
     * Funktionsweise:
     * 1. Lädt/erstellt die Package-Registry aus allen verfügbaren Projekten
     * 2. Analysiert alle angeforderten Projekte und deren Abhängigkeiten
     * 3. Berechnet Version-Scores für jedes Projekt (Summe der Package-Versionen)
     * 4. Sortiert Projekte nach Score - höchste Versionen werden zuerst geladen
     * 5. Lädt Projekte sequenziell mit allow_downgrade=true
     * 6. Später geladene Projekte nutzen automatisch bereits geladene höhere Versionen
     * 
     * Vorteile gegenüber mehreren require() Aufrufen:
     * - Automatische Konflikt-Resolution bei unterschiedlichen Package-Versionen
     * - Optimale Lade-Reihenfolge wird automatisch ermittelt
     * - Nur ein Registry-Scan statt mehrere
     * - Vermeidet Exceptions durch falsche Lade-Reihenfolge
     * - Gibt detaillierten Status für jedes Projekt zurück
     * 
     * Version-Konflikt Handling:
     * Wenn zwei Projekte unterschiedliche Versionen desselben Packages benötigen
     * (z.B. Projekt A: guzzle 7.5, Projekt B: guzzle 7.8), wird automatisch die
     * höhere Version (7.8) geladen und beide Projekte nutzen diese.
     * 
     * Beispiel:
     * ```php
     * $result = bx_dependency_resolver::requireMultiple([
     *     'modified_qrcode',
     *     'modified_tcpdf',
     *     'modified_barcode'
     * ]);
     * 
     * // Prüfe Ergebnis
     * foreach ($result as $project_name => $project_info) {
     *     if ($project_info['status'] === 'loaded') {
     *         echo "✓ {$project_name} geladen\n";
     *         // Verfügbare Packages anzeigen
     *         foreach ($project_info['packages'] as $pkg => $ver) {
     *             echo "  - {$pkg}: {$ver}\n";
     *         }
     *     } else {
     *         echo "✗ {$project_name} Fehler: {$project_info['error']}\n";
     *     }
     * }
     * ```
     * 
     * @param array $project_names Array mit Projekt-Namen (Ordnernamen in bx_composer_libs/)
     *                             Beispiel: ['modified_qrcode', 'modified_tcpdf']
     * 
     * @return array Assoziatives Array mit Projekt-Namen als Keys und Status-Info als Values
     *               Struktur pro Projekt:
     *               [
     *                   'project_name' => [
     *                       'status' => 'loaded'|'error',  // Lade-Status
     *                       'packages' => [                 // Nur bei status=loaded
     *                           'package/name' => 'version'
     *                       ],
     *                       'error' => 'Fehlermeldung'      // Nur bei status=error
     *                   ]
     *               ]
     * 
     * @throws Exception Wird NICHT geworfen - Fehler werden im Result-Array zurückgegeben
     * 
     * @since 1.0
     * @see require() Für Laden einzelner Projekte (weniger effizient)
     * @see optimizeLoadOrder() Interne Methode für Sortierung
     */
    public static function requireMultiple($project_names) {
        self::init();
        
        // Security: Validiere alle Projekt-Namen
        foreach ($project_names as $project_name) {
            self::validateProjectName($project_name);
        }
        
        if (empty($project_names)) {
            return [];
        }
        
        self::log("Loading multiple projects: " . implode(', ', $project_names), 'INFO');        
        // Registry laden
        if (self::$package_registry === null) {
            self::$package_registry = self::buildRegistry();
        }
        
        self::debug("Loading multiple projects: " . implode(', ', $project_names));
        
        // Schritt 1: Optimale Lade-Reihenfolge ermitteln
        $optimized_order = self::optimizeLoadOrder($project_names);
        
        self::debug("Optimized load order: " . implode(' → ', $optimized_order));
        self::log("Optimized load order: " . implode(' → ', $optimized_order), 'DEBUG');
        
        // Schritt 2: Projekte in optimaler Reihenfolge laden
        $results = [];
        foreach ($optimized_order as $project_name) {
            try {
                self::require($project_name, true); // true = allow_downgrade
                $results[$project_name] = [
                    'status' => 'loaded',
                    'packages' => self::getProjectPackages($project_name)
                ];
            } catch (Exception $e) {
                $results[$project_name] = [
                    'status' => 'error',
                    'error' => $e->getMessage()
                ];
                self::debug("Failed to load '{$project_name}': " . $e->getMessage());
                self::log("Failed to load '{$project_name}': " . $e->getMessage(), 'ERROR', $project_name);
            }
        }
        
        self::log("Successfully loaded " . count(array_filter($results, function($r) { return $r['status'] === 'loaded'; })) . " of " . count($project_names) . " projects", 'INFO');
        
        return $results;
    }
    
    /**
     * Validiert einen Projekt-Namen gegen Path-Traversal und ungültige Zeichen
     * 
     * Diese Methode ist eine Security-Funktion und verhindert:
     * - Path-Traversal-Angriffe (../../etc/passwd)
     * - Ungültige Zeichen in Projekt-Namen
     * - Directory-Traversal über relative Pfade
     * 
     * Erlaubt sind nur:
     * - Alphanumerische Zeichen (a-z, A-Z, 0-9)
     * - Underscores (_)
     * - Dashes (-)
     * 
     * Beispiele:
     * - ✓ "modified_barcode" - OK
     * - ✓ "modified-qrcode"  - OK
     * - ✓ "BX_Module_2"      - OK
     * - ✗ "../../../etc"     - Security-Exception
     * - ✗ "projekt/subdir"   - Invalid-Exception
     * - ✗ "projekt name"     - Invalid-Exception (Leerzeichen)
     * 
     * @param string $project_name Zu validierender Projekt-Name
     * @throws BxInvalidProjectNameException Bei ungültigen Zeichen
     * @throws BxSecurityException Bei Path-Traversal-Versuch
     * @return void
     * @since 1.0
     */
    private static function validateProjectName($project_name) {
        // Empty-Check
        if (empty($project_name)) {
            throw new BxInvalidProjectNameException(
                "Project name cannot be empty.",
                $project_name,
                'empty_name'
            );
        }
        
        // Path-Traversal Detection (explizit für bessere Fehler-Meldung)
        if (strpos($project_name, '..') !== false) {
            self::log("SECURITY: Path traversal attempt detected: '{$project_name}'", 'ERROR');
            throw new BxSecurityException(
                "BX Dependency Resolver SECURITY: Path traversal attempt detected in project name: '{$project_name}'",
                'path_traversal',
                $project_name
            );
        }
        
        // Directory-Separator Detection
        if (strpos($project_name, '/') !== false || strpos($project_name, '\\') !== false) {
            self::log("SECURITY: Directory separator in project name: '{$project_name}'", 'ERROR');
            throw new BxSecurityException(
                "BX Dependency Resolver SECURITY: Directory separators not allowed in project name: '{$project_name}'",
                'directory_separator',
                $project_name
            );
        }
        
        // Character Validation (alphanumeric, underscore, dash only)
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $project_name)) {
            throw new BxInvalidProjectNameException(
                "BX Dependency Resolver: Invalid project name '{$project_name}'. " .
                "Only alphanumeric characters, underscores (_) and dashes (-) are allowed.",
                $project_name,
                'invalid_characters'
            );
        }
    }
    
    /**
     * Lädt ein Projekt und dessen Abhängigkeiten
     * 
     * @param string $project_name Name des Projekt-Ordners (z.B. 'modified_barcode')
     * @param bool $allow_downgrade Akzeptiere bereits geladene höhere Versionen statt benötigter niedrigerer
     * @return bool True bei Erfolg
     * @throws BxInvalidProjectNameException Bei ungültigem Projekt-Namen
     * @throws BxSecurityException Bei Path-Traversal-Versuch
     * @throws BxProjectNotFoundException Wenn Projekt nicht gefunden wird
     * @throws BxAutoloaderNotFoundException Wenn Autoloader fehlt (composer install erforderlich)
     * @throws BxMajorVersionConflictException Bei Major-Version-Konflikt (Development-Mode)
     * @throws BxVersionDowngradeException Wenn geladene Version niedriger als benötigte
     */
    public static function require($project_name, $allow_downgrade = true) {
        self::init();
        
        // Security: Validiere Projekt-Namen
        self::validateProjectName($project_name);
        
        // Bereits geladen?
        if (isset(self::$loaded_projects[$project_name])) {
            self::debug("Project '{$project_name}' already loaded");
            self::log("Project '{$project_name}' already loaded (skipped)", 'DEBUG', $project_name);
            return true;
        }
        
        self::log("Loading project '{$project_name}' (allow_downgrade: " . ($allow_downgrade ? 'true' : 'false') . ")", 'INFO', $project_name);
        
        // Projekt-Pfad prüfen
        $project_path = self::$base_path . $project_name . '/';
        if (!is_dir($project_path)) {
            self::log("Project directory not found: {$project_path}", 'ERROR', $project_name);
            throw new BxProjectNotFoundException(
                "BX Dependency Resolver: Project '{$project_name}' not found in " . self::$base_path,
                $project_name,
                self::$base_path
            );
        }
        
        // Registry laden/erstellen
        if (self::$package_registry === null) {
            self::$package_registry = self::buildRegistry();
        }
        
        // Projekt laden
        $autoload_path = $project_path . 'vendor/autoload.php';
        if (!file_exists($autoload_path)) {
            self::log("Autoloader not found: {$autoload_path}", 'ERROR', $project_name);
            throw new BxAutoloaderNotFoundException(
                "BX Dependency Resolver: Autoloader not found for project '{$project_name}'. Run 'composer install' in {$project_path}",
                $project_name,
                $autoload_path
            );
        }
        
        // Package-Info aus Registry holen
        $packages = self::getProjectPackages($project_name);
        self::log("Found " . count($packages) . " packages in project '{$project_name}'", 'DEBUG', $project_name);
        
        // Prüfe auf Konflikte mit bereits geladenen Packages
        foreach ($packages as $package_name => $version) {
            self::checkConflict($package_name, $version, $project_name, $allow_downgrade);
        }
        
        // Autoloader laden
        require_once $autoload_path;
        self::$loaded_projects[$project_name] = [
            'path' => $project_path,
            'packages' => $packages,
            'loaded_at' => time()
        ];
        
        self::debug("Loaded project '{$project_name}' with packages: " . implode(', ', array_keys($packages)));
        self::log("Successfully loaded project '{$project_name}' with " . count($packages) . " packages", 'INFO', $project_name);
        
        return true;
    }
    
    /**
     * Lädt ein einzelnes Package über das beste verfügbare Projekt
     * 
     * Diese Methode ist eine Convenience-Funktion zum Laden einzelner Packages.
     * Sie findet automatisch das Projekt mit der höchsten verfügbaren Version
     * des gewünschten Packages und lädt dieses Projekt.
     * 
     * Funktionsweise:
     * 1. Sucht das Package in der Registry
     * 2. Wählt das Projekt mit der höchsten Version
     * 3. Lädt das komplette Projekt (inkl. aller Dependencies)
     * 4. Das gewünschte Package ist danach verfügbar
     * 
     * Version-Handling bei bereits geladenem Package:
     * - $require_best_version = false (Standard): Nutze bereits geladene Version,
     *   auch wenn eine höhere verfügbar wäre. Debug-Warnung wird ausgegeben.
     * - $require_best_version = true (Strict): Exception wenn geladene Version
     *   niedriger ist als die beste verfügbare Version.
     * 
     * Vorteile gegenüber require():
     * - Keine Kenntnis des Projekt-Namens erforderlich
     * - Automatische Auswahl der höchsten Version
     * - Einfachere API für den Entwickler
     * - Optionale Versions-Prüfung im Strict-Mode
     * 
     * Hinweis:
     * Die Methode lädt immer das GESAMTE Projekt mit allen Dependencies.
     * Wenn das Package in mehreren Projekten vorhanden ist, wird automatisch
     * die höchste Version gewählt.
     * 
     * Beispiele:
     * ```php
     * // Guzzle laden (nutzt ggf. bereits geladene Version)
     * bx_dependency_resolver::requirePackage('guzzlehttp/guzzle');
     * $client = new \GuzzleHttp\Client();
     * 
     * // Strict-Mode: Exception wenn nicht beste Version geladen
     * try {
     *     bx_dependency_resolver::requirePackage('guzzlehttp/guzzle', false, true);
     * } catch (Exception $e) {
     *     echo "Bessere Version verfügbar: " . $e->getMessage();
     * }
     * 
     * // Mit Fehlerbehandlung
     * try {
     *     bx_dependency_resolver::requirePackage('vendor/package');
     * } catch (Exception $e) {
     *     echo "Package nicht gefunden: " . $e->getMessage();
     * }
     * 
     * // Prüfen, welches Projekt geladen wurde
     * $project = bx_dependency_resolver::findBestProjectForPackage('guzzlehttp/guzzle');
     * echo "Guzzle kommt aus Projekt: {$project}";
     * ```
     * 
     * @param string $package_name Vollständiger Package-Name (z.B. 'guzzlehttp/guzzle')
     * @param bool $allow_downgrade Akzeptiere bereits geladene höhere Versionen statt benötigter niedrigerer
     * @param bool $require_best_version Strict-Mode: Exception wenn geladene Version niedriger
     * @return bool True bei Erfolg
     * @throws BxPackageNotFoundException Wenn Package nicht gefunden wird
     * @throws BxProjectNotFoundException Wenn Projekt mit Package nicht gefunden
     * @throws BxAutoloaderNotFoundException Wenn Autoloader fehlt
     * @throws BxMajorVersionConflictException Bei Major-Version-Konflikt
     * @throws BxVersionDowngradeException Wenn geladene Version niedriger im Strict-Mode
     * 
     * @since 1.0
     * @see require() Zum direkten Laden eines bekannten Projekts
     * @see findBestProjectForPackage() Zum Ermitteln des besten Projekts ohne Laden
     */
    public static function requirePackage($package_name, $allow_downgrade = true, $require_best_version = false) {
        self::init();
        
        // Registry laden wenn nötig
        if (self::$package_registry === null) {
            self::$package_registry = self::buildRegistry();
        }
        
        // Finde beste verfügbare Version
        $package_info = self::getPackageInfo($package_name);
        
        if ($package_info === null || empty($package_info)) {
            throw new BxPackageNotFoundException(
                "BX Dependency Resolver: Package '{$package_name}' not found in any project.\n" .
                "Available packages: " . implode(', ', array_keys(self::$package_registry)),
                $package_name
            );
        }
        
        $best_version = $package_info[0]['version'];
        $best_project = $package_info[0]['project'];
        
        // Prüfe ob Package bereits durch ein geladenes Projekt verfügbar ist
        foreach (self::$loaded_projects as $project_name => $project_info) {
            if (isset($project_info['packages'][$package_name])) {
                $loaded_version = $project_info['packages'][$package_name];
                
                // Normalisiere Versionen für Vergleich
                $loaded_norm = self::normalizeVersion($loaded_version);
                $best_norm   = self::normalizeVersion($best_version);
                
                $comparison = version_compare($loaded_norm, $best_norm);
                
                if ($comparison >= 0) {
                    // Geladene Version ist gleich oder besser
                    self::debug("Package '{$package_name}' v{$loaded_version} already loaded from '{$project_name}' (best available: v{$best_version})");
                    return true;
                } else {
                    // Geladene Version ist niedriger als beste verfügbare
                    $message = "Package '{$package_name}': v{$loaded_version} is loaded from '{$project_name}', but v{$best_version} is available in '{$best_project}'";
                    
                    if ($require_best_version) {
                        // Strict-Mode: Exception werfen
                        throw new Exception(
                            "BX Dependency Resolver: {$message}\n" .
                            "Strict mode enabled: Cannot load lower version.\n" .
                            "Solution: Load project '{$best_project}' before '{$project_name}' or use requireMultiple()."
                        );
                    } else {
                        // Relaxed-Mode: Warnung + weiter nutzen
                        self::debug("⚠ Warning: {$message} (using loaded version)");
                        return true;
                    }
                }
            }
        }
        
        // Package noch nicht geladen - lade bestes Projekt
        self::debug("Loading package '{$package_name}' (v{$best_version}) from project '{$best_project}'");
        
        // Projekt laden
        return self::require($best_project, $allow_downgrade);
    }
    
    /**
     * Optimiert die Lade-Reihenfolge von Projekten nach Package-Versionen
     * 
     * Diese Methode sortiert die zu ladenden Projekte so, dass Projekte mit
     * höheren Package-Versionen zuerst geladen werden. Dies verhindert
     * Versions-Konflikte, da spätere Projekte dann die bereits geladenen
     * höheren Versionen nutzen können.
     * 
     * Funktionsweise:
     * 1. Berechnet für jedes Projekt einen Score (Summe aller Package-Versionen)
     * 2. Bereits geladene Projekte bekommen Score -1 (werden übersprungen)
     * 3. Sortiert Projekte absteigend nach Score
     * 4. Gibt sortierte Projekt-Namen zurück
     * 
     * Beispiel:
     * - Projekt A hat Guzzle 7.5 (Score: 7.005.000)
     * - Projekt B hat Guzzle 7.8 (Score: 7.008.000)
     * → Projekt B wird zuerst geladen (höherer Score)
     * → Projekt A nutzt dann Guzzle 7.8 von Projekt B
     * 
     * @param array $project_names Array mit Projekt-Namen zum Sortieren
     * @return array Sortierte Projekt-Namen (höchste Versionen zuerst)
     * @since 1.0
     * @see versionToScore() Für Score-Berechnung
     * @see requireMultiple() Nutzt diese Methode für optimales Laden
     */
    private static function optimizeLoadOrder($project_names) {
        $project_scores = [];
        
        foreach ($project_names as $project_name) {
            // Bereits geladen? → ans Ende (wird übersprungen)
            if (isset(self::$loaded_projects[$project_name])) {
                $project_scores[$project_name] = -1;
                continue;
            }
            
            $packages = self::getProjectPackages($project_name);
            $score = 0;
            
            // Score = Summe der normalisierten Versionen
            foreach ($packages as $package_name => $version) {
                $score += self::versionToScore($version);
            }
            
            $project_scores[$project_name] = $score;
        }
        
        // Sortiere nach Score (höchste zuerst)
        arsort($project_scores);
        
        return array_keys($project_scores);
    }
    
    /**
     * Konvertiert eine Versions-String zu einem numerischen Score
     * 
     * Der Score ermöglicht einfachen Zahlen-Vergleich von Versionen.
     * Höhere Versionen haben höhere Scores.
     * 
     * Score-Berechnung:
     * - Major * 1.000.000
     * - Minor * 1.000
     * - Patch * 1
     * 
     * Beispiele:
     * - Version "7.8.2" → Score: 7.008.002
     * - Version "6.5.0" → Score: 6.005.000
     * - Version "10.2.5" → Score: 10.002.005
     * 
     * Verwendung:
     * Wird von optimizeLoadOrder() genutzt, um Projekte mit höheren
     * Versions-Summen zu priorisieren.
     * 
     * @param string $version Versions-String (z.B. "7.8.2")
     * @return int Numerischer Score für Vergleich
     * @since 1.0
     * @see optimizeLoadOrder() Nutzt diese Methode für Sortierung
     */
    private static function versionToScore($version) {
        $normalized = self::normalizeVersion($version);
        $parts = explode('.', $normalized);
        
        $score = 0;
        $multiplier = 1000000; // Major * 1M, Minor * 1K, Patch * 1
        
        foreach ($parts as $part) {
            if (is_numeric($part)) {
                $score += (int)$part * $multiplier;
                $multiplier /= 1000;
            }
        }
        
        return $score;
    }
    
    /**
     * Erstellt die zentrale Package-Registry aus allen verfügbaren Projekten
     * 
     * Diese Methode scannt alle Projekt-Ordner in bx_composer_libs/, liest deren
     * composer.lock Dateien und erstellt eine zentrale Registry aller verfügbaren
     * Packages mit ihren Versionen und Projekt-Zuordnungen.
     * 
     * Funktionsweise:
     * 1. Prüft Cache-Datei (registry.cache) - wenn gültig, direkt zurückgeben
     * 2. Scannt alle Ordner in bx_composer_libs/
     * 3. Liest composer.lock aus jedem Projekt
     * 4. Extrahiert alle Packages mit Versionen
     * 5. Gruppiert Packages nach Namen (mehrere Projekte können gleiches Package haben)
     * 6. Sortiert Versionen pro Package (höchste zuerst)
     * 7. Speichert Registry im Cache (JSON-Format, 1h TTL)
     * 
     * Registry-Struktur:
     * ```php
     * [
     *     'guzzlehttp/guzzle' => [
     *         [
     *             'project' => 'modified_qrcode',
     *             'version' => '7.8.0',
     *             'path' => '/path/to/project/',
     *             'requires' => [...]
     *         ],
     *         [
     *             'project' => 'modified_tcpdf',
     *             'version' => '7.5.0',
     *             ...
     *         ]
     *     ],
     *     'vendor/package' => [...]
     * ]
     * ```
     * 
     * Cache:
     * - TTL: 1 Stunde (3600 Sekunden)
     * - Format: JSON (sicher gegen Object Injection)
     * - Location: cache/bx_dependency_resolver/registry.cache
     * - Invalidierung: Nach composer install/update mit clearCache()
     * 
     * @return array Package-Registry mit allen verfügbaren Packages
     * @since 1.0
     * @see clearCache() Zum Invalidieren des Caches
     */
    private static function buildRegistry() {
        // Cache prüfen (nur wenn Cache-Verzeichnis existiert)
        $cache_file = self::$cache_path . 'registry.cache';
        $content = false;
        
        // Prüfe ob Cache-Datei existiert, bevor file_get_contents() aufgerufen wird
        // Verhindert Warnings wenn Datei nicht existiert
        if (file_exists($cache_file)) {
            $content = @file_get_contents($cache_file);
        }
        
        if ($content !== false) {
            $cache_data = json_decode($content, true);
            
            // Validiere Cache-Struktur und Expiry
            if ($cache_data && 
                is_array($cache_data) && 
                isset($cache_data['registry']) && 
                isset($cache_data['project_index']) &&  // <- Index muss vorhanden sein
                isset($cache_data['expires']) && 
                is_numeric($cache_data['expires']) && 
                $cache_data['expires'] > time()) {
                
                self::debug("Registry loaded from cache (expires in " . 
                           ($cache_data['expires'] - time()) . " seconds)");
                
                // Setze beide: Registry UND Index
                self::$project_index = $cache_data['project_index'];
                return $cache_data['registry'];
            }
            
            // Cache existiert, aber invalid/expired
            self::debug("Cache file exists but is invalid or expired");
        }
        
        self::debug("Building new registry...");
        
        $registry = [];
        
        // Alle Projekt-Ordner scannen
        if (!is_dir(self::$base_path)) {
            self::debug("Base path does not exist: " . self::$base_path);
            return $registry;
        }
        
        $projects = array_diff(scandir(self::$base_path), ['.', '..']);
        
        foreach ($projects as $project_name) {
            $project_path = self::$base_path . $project_name . '/';
            
            if (!is_dir($project_path)) {
                continue;
            }
            
            $lock_file = $project_path . 'composer.lock';
            $json_file = $project_path . 'composer.json';
            
            if (!file_exists($lock_file) || !file_exists($json_file)) {
                self::debug("Skipping '{$project_name}': Missing composer files");
                continue;
            }
            
            // composer.lock parsen
            $lock_data = json_decode(file_get_contents($lock_file), true);
            if (!$lock_data || !isset($lock_data['packages'])) {
                self::debug("Skipping '{$project_name}': Invalid composer.lock");
                continue;
            }
            
            // Alle Packages aus diesem Projekt registrieren
            foreach ($lock_data['packages'] as $package) {
                $package_name    = $package['name'];
                $package_version = $package['version'];
                
                if (!isset($registry[$package_name])) {
                    $registry[$package_name] = [];
                }
                
                $registry[$package_name][] = [
                    'project'  => $project_name,
                    'version'  => $package_version,
                    'path'     => $project_path,
                    'requires' => $package['require'] ?? []
                ];
            }
        }
        
        // Nach Version sortieren (höchste zuerst)
        foreach ($registry as $package_name => &$versions) {
            usort($versions, function($a, $b) {
                return version_compare(
                    self::normalizeVersion($b['version']),
                    self::normalizeVersion($a['version'])
                );
            });
        }
        
        // Performance-Optimierung: Project-Index erstellen (invertierter Index)
        // Verhindert O(n²) Lookup in getProjectPackages()
        self::$project_index = self::buildProjectIndex($registry);
        
        self::debug("Built project index for " . count(self::$project_index) . " projects");
        
        // Cache speichern (Registry UND Index)
        $cache_data = [
            'registry' => $registry,
            'project_index' => self::$project_index,  // <- Index mit cachen
            'expires'  => time() + self::$cache_lifetime
        ];
        file_put_contents($cache_file, json_encode($cache_data), LOCK_EX);
        
        self::debug("Registry built with " . count($registry) . " packages");
        
        return $registry;
    }
    
    /**
     * Erstellt einen invertierten Index: Projekt-Name => Packages
     * 
     * Performance-Optimierung für getProjectPackages().
     * Statt für jedes Projekt die komplette Registry zu durchsuchen (O(n²)),
     * wird einmalig ein Index erstellt, der O(1) Lookups ermöglicht.
     * 
     * Beispiel-Struktur:
     * ```php
     * [
     *     'modified_qrcode' => [
     *         'guzzlehttp/guzzle' => '7.8.0',
     *         'symfony/console' => '6.4.0'
     *     ],
     *     'modified_tcpdf' => [...]
     * ]
     * ```
     * 
     * Performance-Vergleich:
     * - Ohne Index: 10 Projekte × 100 Packages = 1.000 Iterationen
     * - Mit Index: 10 Projekte × 1 Lookup = 10 Lookups ✓
     * 
     * @param array $registry Die Package-Registry
     * @return array Project-Index (Projekt-Name => [Package => Version])
     * @since 1.0
     */
    private static function buildProjectIndex($registry) {
        $index = [];
        
        foreach ($registry as $package_name => $versions) {
            foreach ($versions as $version_info) {
                $project = $version_info['project'];
                
                if (!isset($index[$project])) {
                    $index[$project] = [];
                }
                
                // Speichere nur die höchste Version (Registry ist bereits sortiert)
                if (!isset($index[$project][$package_name])) {
                    $index[$project][$package_name] = $version_info['version'];
                }
            }
        }
        
        return $index;
    }
    
    /**
     * Holt alle Packages eines bestimmten Projekts aus der Registry
     * 
     * Nutzt den Project-Index für O(1) Lookup (statt O(n) Registry-Durchsuchung).
     * 
     * Durchsucht die Package-Registry und extrahiert alle Packages,
     * die zum angegebenen Projekt gehören.
     * 
     * Beispiel-Rückgabe:
     * ```php
     * [
     *     'guzzlehttp/guzzle' => '7.8.0',
     *     'symfony/http-client' => '6.4.0',
     *     'psr/http-message' => '2.0'
     * ]
     * ```
     * 
     * @param string $project_name Name des Projekts (z.B. 'modified_qrcode')
     * @return array Assoziatives Array: Package-Name => Version
     * @since 1.0
     */
    private static function getProjectPackages($project_name) {
        // Performance: O(1) Index-Lookup statt O(n) Registry-Durchsuchung
        if (self::$project_index !== null && isset(self::$project_index[$project_name])) {
            return self::$project_index[$project_name];
        }
        
        // Fallback: Index nicht verfügbar (sollte nicht passieren)
        // Baue Index on-the-fly wenn nötig
        if (self::$project_index === null && self::$package_registry !== null) {
            self::$project_index = self::buildProjectIndex(self::$package_registry);
            
            if (isset(self::$project_index[$project_name])) {
                return self::$project_index[$project_name];
            }
        }
        
        // Projekt nicht gefunden
        return [];
    }
    
    /**
     * Prüft auf Version-Konflikte zwischen bereits geladenen und zu ladenden Packages
     * 
     * Diese Methode ist der Kern der Konflikt-Erkennung und -Resolution des Dependency Resolvers.
     * Sie wird für jedes Package eines zu ladenden Projekts aufgerufen und prüft, ob bereits
     * eine andere Version desselben Packages von einem anderen Projekt geladen wurde.
     * 
     * Konflikt-Szenarien und Handling:
     * 
     * 1. MAJOR-VERSION-KONFLIKT (KRITISCH):
     *    Geladen: Package v6.x, Benötigt: Package v7.x
     *    → Development: EXCEPTION! (Entwickler muss fixen)
     *    → Production: Error-Log + return false (Graceful Degradation)
     *    Grund: Major-Versionen sind per Definition inkompatibel (Breaking Changes).
     * 
     * 2. SAME-MAJOR, HÖHERE VERSION GELADEN:
     *    Geladen: Package v7.8, Benötigt: Package v7.5
     *    → OK wenn allow_downgrade=true (Standard)
     *    → Projekt nutzt die höhere bereits geladene Version
     *    → Debug-Meldung: "using already loaded X (higher version)"
     *    Grund: Höhere Minor/Patch-Versionen sind abwärtskompatibel.
     * 
     * 3. SAME-MAJOR, NIEDRIGERE VERSION GELADEN:
     *    Geladen: Package v7.5, Benötigt: Package v7.8
     *    → EXCEPTION! Kann nicht auf höhere Version upgraden (bereits geladen).
     *    → Lösung: requireMultiple() nutzt automatisch richtige Lade-Reihenfolge.
     *    Grund: Bereits geladene Klassen können nicht überschrieben werden.
     * 
     * 4. IDENTISCHE VERSION:
     *    Geladen: Package v7.8, Benötigt: Package v7.8
     *    → OK, keine Aktion nötig.
     *    → Debug-Meldung: "version X already loaded"
     * 
     * Version-Kompatibilität basiert auf Semantic Versioning (SemVer):
     * - Major: Breaking Changes, inkompatibel (6.x → 7.x)
     * - Minor: Neue Features, abwärtskompatibel (7.5 → 7.8)
     * - Patch: Bugfixes, abwärtskompatibel (7.8.1 → 7.8.2)
     * 
     * Production-Mode (BX_DEPENDENCY_PRODUCTION):
     * Im Production-Mode werden Major-Version-Konflikte NICHT als Exception geworfen,
     * sondern geloggt und false zurückgegeben. Dies verhindert Checkout-Crashes im
     * Live-Shop bei unerwarteten Konflikten. Der Konflikt wird in:
     * - PHP error_log() geschrieben
     * - Dedizierte Log-Datei: cache/bx_dependency_resolver/conflicts.log
     * 
     * Aktivierung Production-Mode:
     * ```php
     * define('BX_DEPENDENCY_PRODUCTION', true);
     * ```
     * 
     * Warum diese strikte Prüfung?
     * - PHP kann keine Klassen entladen oder überschreiben
     * - Runtime-Fehler durch inkompatible Versionen sind schwer zu debuggen
     * - Fehler soll beim Entwickler auftreten, nicht beim Shopbetreiber
     * - Production-Mode ermöglicht Graceful Degradation im Live-Betrieb
     * 
     * Best Practices:
     * - Nutze requireMultiple() für automatische Optimierung
     * - Halte alle Module auf gleicher Major-Version
     * - Bei Konflikten: Beide Module aktualisieren oder eines entfernen
     * - Nutze validateProjects() vor Deployment für Smoke-Tests
     * 
     * Beispiele:
     * ```php
     * // OK: Same-Major, höhere Version nutzen
     * require('projekt_a'); // lädt guzzle 7.8
     * require('projekt_b'); // braucht guzzle 7.5 → nutzt 7.8 ✓
     * 
     * // FEHLER: Major-Konflikt (Development)
     * require('projekt_a'); // lädt guzzle 6.5
     * require('projekt_b'); // braucht guzzle 7.8 → EXCEPTION! ✗
     * 
     * // Production-Mode: Konflikt wird geloggt statt Exception
     * define('BX_DEPENDENCY_PRODUCTION', true);
     * require('projekt_a'); // lädt guzzle 6.5
     * require('projekt_b'); // braucht guzzle 7.8 → return false + Log ⚠
     * 
     * // FEHLER: Falsche Reihenfolge
     * require('projekt_a'); // lädt guzzle 7.5
     * require('projekt_b'); // braucht guzzle 7.8 → EXCEPTION! ✗
     * // Lösung: requireMultiple(['projekt_b', 'projekt_a'])
     * ```
     * 
     * @param string $package_name Vollständiger Package-Name (z.B. 'guzzlehttp/guzzle')
     * @param string $version Benötigte Version des zu ladenden Projekts (z.B. '7.8.0')
     * @param string $project_name Name des Projekts, das das Package benötigt
     * @param bool $allow_downgrade Wenn true: Akzeptiere bereits geladene höhere Versionen.
     *                              Wenn false: Warne im Debug-Modus bei Downgrade.
     *                              Hat KEINEN Einfluss auf Major-Version-Check (immer strict).
     * 
     * @throws BxMajorVersionConflictException Bei Major-Version-Konflikt (Development-Mode)
     * @throws BxVersionDowngradeException Wenn geladene Version niedriger als benötigte
     * 
     * @return bool|void true bei Erfolg (Szenario 2), void bei identischer Version (Szenario 4)
     *                   false bei Major-Konflikt im Production-Mode (Szenario 1 mit Production)
     * 
     * @since 1.0
     * @see require() Nutzt diese Methode für jedes Package
     * @see requireMultiple() Empfohlene Methode zur Vermeidung von Lade-Reihenfolge-Problemen
     * @see logError() Für Production-Mode Logging
     * @see validateProjects() Smoke-Test vor Deployment
     */
    private static function checkConflict($package_name, $version, $project_name, $allow_downgrade = true) {
        // Prüfe ob Package bereits von anderem Projekt geladen
        foreach (self::$loaded_projects as $loaded_name => $loaded_info) {
            if (isset($loaded_info['packages'][$package_name])) {
                $loaded_version = $loaded_info['packages'][$package_name];
                
                // Version-Vergleich
                $version_norm = self::normalizeVersion($version);
                $loaded_norm  = self::normalizeVersion($loaded_version);
                
                if ($version_norm !== $loaded_norm) {
                    // Prüfe Major-Version Kompatibilität
                    $loaded_major   = self::getMajorVersion($loaded_norm);
                    $required_major = self::getMajorVersion($version_norm);
                    
                    if ($loaded_major !== $required_major) {
                        // CRITICAL: Major version conflict - incompatible!
                        $error_message = sprintf(
                            "BX Dependency Resolver: FATAL - Incompatible major versions detected!\n" .
                            "Package: '%s'\n" .
                            "Project '%s' loaded version %s (v%s.x)\n" .
                            "Project '%s' requires version %s (v%s.x)\n\n" .
                            "These major versions are NOT compatible and cannot coexist.\n" .
                            "SOLUTION: Either:\n" .
                            "  1. Update both projects to use the same major version\n" .
                            "  2. Use only one of these projects\n" .
                            "  3. Contact the module developers for compatibility updates\n\n" .
                            "This error prevents runtime failures in production.",
                            $package_name,
                            $loaded_name, 
                            $loaded_version, 
                            $loaded_major,
                            $project_name, 
                            $version, 
                            $required_major
                        );
                        
                        // Production-Mode: Log + return false statt Exception
                        if (defined('BX_DEPENDENCY_PRODUCTION') && BX_DEPENDENCY_PRODUCTION === true) {
                            self::logError($error_message, [
                                'package'          => $package_name,
                                'loaded_version'   => $loaded_version,
                                'required_version' => $version,
                                'loaded_by'        => $loaded_name,
                                'required_by'      => $project_name
                            ]);
                            self::debug("⚠ PRODUCTION MODE: Major conflict logged, returning false");
                            return false; // Graceful degradation
                        }
                        
                        // Development-Mode: Spezifische Exception werfen
                        throw new BxMajorVersionConflictException(
                            $error_message,
                            $package_name,
                            $loaded_version,
                            $version,
                            $loaded_name,
                            $project_name
                        );
                    }
                    
                    // Prüfe Kompatibilität
                    $comparison = version_compare($loaded_norm, $version_norm);
                    
                    if ($comparison > 0) {
                        // Geladene Version ist HÖHER als benötigte
                        if ($allow_downgrade) {
                            self::debug("Package '{$package_name}': Project '{$project_name}' requires {$version}, but using already loaded {$loaded_version} (higher version)");
                            return; // OK - höhere Version nutzen
                        } else {
                            self::debug("Warning: Package '{$package_name}': Project '{$project_name}' wants {$version}, but {$loaded_version} is loaded");
                        }
                    } else {
                        // Geladene Version ist NIEDRIGER als benötigte
                        throw new BxVersionDowngradeException(
                            "BX Dependency Resolver: Version conflict for package '{$package_name}'!\n" .
                            "Project '{$project_name}' requires version {$version}, " .
                            "but project '{$loaded_name}' already loaded version {$loaded_version} (older).\n" .
                            "Solution: Load projects with newer versions first using requireMultiple().",
                            $package_name,
                            $loaded_version,
                            $version,
                            $loaded_name,
                            $project_name
                        );
                    }
                } else {
                    self::debug("Package '{$package_name}' version {$version} already loaded from '{$loaded_name}'");
                }
            }
        }
    }
    
    /**
     * Normalisiert einen Versions-String für standardisierten Vergleich
     * 
     * Entfernt gebräuchliche Präfixe und Suffixe, die den Versions-Vergleich
     * stören würden.
     * 
     * Transformationen:
     * - Entfernt führendes 'v' (v7.8.0 → 7.8.0)
     * - Entfernt -dev Suffixe (7.8.0-dev → 7.8.0)
     * 
     * Beispiele:
     * - "v7.8.0" → "7.8.0"
     * - "v6.5.2-dev" → "6.5.2"
     * - "7.5.0" → "7.5.0" (unverändert)
     * 
     * Verwendung:
     * Wird vor jedem Versions-Vergleich aufgerufen, um konsistente
     * Ergebnisse mit version_compare() zu garantieren.
     * 
     * @param string $version Original Versions-String (z.B. "v7.8.0-dev")
     * @return string Normalisierte Version (z.B. "7.8.0")
     * @since 1.0
     * @see checkConflict() Nutzt diese Methode für Versions-Vergleiche
     */
    private static function normalizeVersion($version) {
        // Entferne 'v' Prefix
        $version = ltrim($version, 'v');
        
        // Entferne dev-Suffixe
        $version = preg_replace('/-dev.*$/', '', $version);
        
        // Normalisiere auf Major.Minor.Patch Format (3-stellig)
        // "2.0" → "2.0.0", "7" → "7.0.0"
        $parts = explode('.', $version);
        while (count($parts) < 3) {
            $parts[] = '0';
        }
        $version = implode('.', array_slice($parts, 0, 3));
        
        return $version;
    }
    
    /**
     * Extrahiert die Major-Version aus einem Versions-String
     * 
     * Die Major-Version ist die erste Zahl in einer Semantic Version.
     * Sie kennzeichnet Breaking Changes - unterschiedliche Major-Versionen
     * sind nicht kompatibel.
     * 
     * Beispiele:
     * - "7.8.2" → "7"
     * - "6.5.0" → "6"
     * - "10.2" → "10"
     * - "invalid" → "0" (Fallback)
     * 
     * Verwendung:
     * Kritisch für Konflikt-Erkennung in checkConflict().
     * Unterschiedliche Major-Versionen führen zu Exception.
     * 
     * @param string $version Normalisierte Version (z.B. "7.5.0")
     * @return string Major-Version als String (z.B. "7")
     * @since 1.0
     * @see checkConflict() Nutzt diese Methode für Kompatibilitäts-Check
     * @see normalizeVersion() Sollte vor dieser Methode aufgerufen werden
     */
    private static function getMajorVersion($version) {
        $parts = explode('.', $version);
        return $parts[0] ?? '0';
    }
    
    /**
     * Gibt Informationen über ein geladenes Projekt zurück
     * 
     * Liefert detaillierte Informationen über ein bereits geladenes Projekt,
     * einschließlich Pfad, Packages und Lade-Zeitpunkt.
     * 
     * Rückgabe-Struktur:
     * ```php
     * [
     *     'path' => '/path/to/project/',
     *     'packages' => [
     *         'guzzlehttp/guzzle' => '7.8.0',
     *         'vendor/package' => '1.2.3'
     *     ],
     *     'loaded_at' => 1706198400 // Unix-Timestamp
     * ]
     * ```
     * 
     * @param string $project_name Name des Projekts (z.B. 'modified_qrcode')
     * @return array|null Array mit Projekt-Info, oder null wenn nicht geladen
     * @since 1.0
     * @see getLoadedProjects() Für Liste aller geladenen Projekte
     */
    public static function getProjectInfo($project_name) {
        return self::$loaded_projects[$project_name] ?? null;
    }
    
    /**
     * Gibt eine Liste aller aktuell geladenen Projekte zurück
     * 
     * Nützlich für Debugging und Monitoring, um zu sehen,
     * welche Projekte bereits geladen wurden.
     * 
     * Beispiel-Rückgabe:
     * ```php
     * ['modified_qrcode', 'modified_tcpdf', 'modified_barcode']
     * ```
     * 
     * @return array Array mit Projekt-Namen (nur Namen, keine Details)
     * @since 1.0
     * @see getProjectInfo() Für detaillierte Informationen zu einem Projekt
     */
    public static function getLoadedProjects() {
        return array_keys(self::$loaded_projects);
    }
    
    /**
     * Gibt Registry-Informationen über ein Package zurück
     * 
     * Liefert alle verfügbaren Versionen eines Packages aus allen Projekten,
     * sortiert nach Version (höchste zuerst).
     * 
     * Rückgabe-Struktur:
     * ```php
     * [
     *     [
     *         'project' => 'modified_qrcode',
     *         'version' => '7.8.0',
     *         'path' => '/path/to/project/',
     *         'requires' => [...]
     *     ],
     *     [
     *         'project' => 'modified_tcpdf',
     *         'version' => '7.5.0',
     *         ...
     *     ]
     * ]
     * ```
     * 
     * Verwendung:
     * - Prüfen, welche Versionen eines Packages verfügbar sind
     * - Ermitteln, welche Projekte ein bestimmtes Package bereitstellen
     * - Debugging von Versions-Konflikten
     * 
     * @param string $package_name Vollständiger Package-Name (z.B. 'guzzlehttp/guzzle')
     * @return array|null Array mit Version-Infos, oder null wenn nicht gefunden
     * @since 1.0
     * @see findBestProjectForPackage() Für direkten Zugriff auf bestes Projekt
     */
    public static function getPackageInfo($package_name) {
        self::init();
        
        if (self::$package_registry === null) {
            self::$package_registry = self::buildRegistry();
        }
        
        return self::$package_registry[$package_name] ?? null;
    }
    
    /**
     * Findet das Projekt mit der höchsten Version eines Packages
     * 
     * Durchsucht die Registry und gibt den Namen des Projekts zurück,
     * das die höchste verfügbare Version des angegebenen Packages hat.
     * 
     * Nützlich um:
     * - Vor dem Laden zu prüfen, welches Projekt das beste ist
     * - In Dokumentation/Logs anzuzeigen, woher ein Package kommt
     * - Manuelle Projekt-Auswahl zu ermöglichen
     * 
     * Beispiel:
     * ```php
     * $project = bx_dependency_resolver::findBestProjectForPackage('guzzlehttp/guzzle');
     * echo "Beste Guzzle-Version in: {$project}";
     * // Output: "Beste Guzzle-Version in: modified_qrcode"
     * ```
     * 
     * @param string $package_name Vollständiger Package-Name (z.B. 'guzzlehttp/guzzle')
     * @return string|null Projekt-Name mit höchster Version, oder null wenn nicht gefunden
     * @since 1.0
     * @see getPackageInfo() Für vollständige Versions-Informationen
     * @see requirePackage() Nutzt diese Methode intern
     */
    public static function findBestProjectForPackage($package_name) {
        $info = self::getPackageInfo($package_name);
        if ($info && !empty($info)) {
            return $info[0]['project']; // Bereits nach Version sortiert
        }
        return null;
    }
    
    /**
     * Löscht den Registry-Cache
     * 
     * Sollte nach jeder Änderung an den Composer-Dependencies aufgerufen werden:
     * - Nach `composer install`
     * - Nach `composer update`
     * - Nach `composer require/remove`
     * - Nach Installation/Deinstallation eines Moduls
     * 
     * Der Cache wird automatisch beim nächsten require() neu aufgebaut.
     * 
     * Beispiel:
     * ```php
     * // Nach Composer-Update
     * exec('cd /path/to/project && composer update');
     * bx_dependency_resolver::clearCache();
     * 
     * // Bei Modul-Installation
     * function installModule($module_name) {
     *     // ... Installation ...
     *     bx_dependency_resolver::clearCache();
     * }
     * ```
     * 
     * @return bool True wenn Cache gelöscht wurde, false wenn kein Cache existierte
     * @since 1.0
     * @see buildRegistry() Erstellt neuen Cache beim nächsten Laden
     */
    public static function clearCache() {
        self::init();
        
        $cache_file = self::$cache_path . 'registry.cache';
        
        // Direkt löschen ohne vorherige file_exists() Prüfung (TOCTOU-safe)
        // @ unterdrückt Warning wenn Datei nicht existiert
        $deleted = @unlink($cache_file);
        
        if ($deleted) {
            self::debug("Cache cleared: {$cache_file}");
            self::log("Cache cleared", 'INFO');
            return true;
        }
        
        // Datei existierte nicht oder konnte nicht gelöscht werden
        self::debug("Cache file not found or could not be deleted: {$cache_file}");
        return false;
    }
    
    /**
     * Gibt Debug-Meldungen aus wenn Debug-Modus aktiv ist
     * 
     * Debug-Modus aktivieren:
     * ```php
     * define('BX_DEPENDENCY_DEBUG', true);
     * ```
     * 
     * Alle Meldungen werden mit Prefix "[BX_DEPENDENCY_RESOLVER]" ausgegeben.
     * 
     * Debug-Infos beinhalten:
     * - Geladene Projekte und deren Packages
     * - Erkannte Versions-Konflikte und deren Auflösung
     * - Lade-Reihenfolge bei requireMultiple()
     * - Cache-Status (geladen/neu erstellt)
     * - Warnings bei Version-Downgrades
     * 
     * @param string $message Debug-Nachricht
     * @return void
     * @since 1.0
     */
    private static function debug($message) {
        if (self::$debug) {
            echo "[BX_DEPENDENCY_RESOLVER] " . $message . "\n";
        }
    }
    
    /**
     * Loggt kritische Fehler (Production-Mode)
     * 
     * Schreibt strukturierte Fehler-Logs für Production-Umgebungen.
     * Nutzt error_log() für System-Logging und erstellt zusätzlich
     * eine dedizierte Log-Datei für Dependency-Konflikte.
     * 
     * @param string $message Fehlermeldung
     * @param array $context Zusätzlicher Kontext (Package, Versionen, etc.)
     * @return void
     * 
     * @since 1.0
     */
    private static function logError($message, $context = []) {
        // System-Log
        error_log("[BX_DEPENDENCY_RESOLVER] " . $message);
        
        // Dedizierte Log-Datei
        $log_file = self::$cache_path . 'conflicts.log';
        $timestamp = date('Y-m-d H:i:s');
        
        $log_entry = "[{$timestamp}] CONFLICT\n";
        $log_entry .= "Message: {$message}\n";
        
        if (!empty($context)) {
            $log_entry .= "Context: " . json_encode($context, JSON_PRETTY_PRINT) . "\n";
        }
        
        $log_entry .= str_repeat('-', 80) . "\n\n";
        
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Gibt die komplette Package-Registry zurück (für Debugging)
     * 
     * Die Registry enthält alle verfügbaren Packages aus allen gescannten
     * Projekten mit Versions-Informationen und Projekt-Zuordnungen.
     * 
     * Nützlich für:
     * - Debugging von Versions-Konflikten
     * - Admin-Panel Anzeige verfügbarer Packages
     * - Analyse der Dependency-Struktur
     * - Dokumentations-Generierung
     * 
     * Beispiel-Verwendung:
     * ```php
     * $registry = bx_dependency_resolver::getRegistry();
     * 
     * // Alle verfügbaren Packages anzeigen
     * foreach ($registry as $package_name => $versions) {
     *     echo "Package: {$package_name}\n";
     *     foreach ($versions as $info) {
     *         echo "  - v{$info['version']} in {$info['project']}\n";
     *     }
     * }
     * ```
     * 
     * @return array Komplette Package-Registry
     * @since 1.0
     * @see buildRegistry() Erstellt die Registry
     * @see getPackageInfo() Für Informationen zu einem einzelnen Package
     */
    public static function getRegistry() {
        self::init();
        
        if (self::$package_registry === null) {
            self::$package_registry = self::buildRegistry();
        }
        
        return self::$package_registry;
    }
    
    /**
     * Validiert Projekt-Kompatibilität ohne sie zu laden (Smoke-Test)
     * 
     * Diese Methode ist ein kritisches Tool für Quality Assurance und sollte
     * nach jeder Modul-Installation oder vor einem Deployment ausgeführt werden.
     * Sie simuliert das Laden aller Projekte und erkennt Konflikte OHNE den
     * eigentlichen Code-Pfad zu durchlaufen.
     * 
     * Funktionsweise:
     * 1. Lädt Registry mit allen verfügbaren Packages
     * 2. Simuliert optimale Lade-Reihenfolge
     * 3. Prüft jeden Package-Konflikt wie beim echten Laden
     * 4. Sammelt ALLE Konflikte statt beim ersten zu stoppen
     * 5. Gibt detaillierten Report zurück
     * 
     * Vorteile gegenüber normalem require():
     * - Erkennt Konflikte VOR dem Live-Betrieb
     * - Unabhängig von konkreten Code-Pfaden
     * - Kein "versteckter" Fehler im seltenen Checkout-Szenario
     * - Alle Konflikte auf einmal sichtbar
     * - Kein Risiko für Production-Shop
     * 
     * Einsatz-Szenarien:
     * - Nach Installation eines neuen Moduls
     * - Vor Deployment auf Live-System
     * - Regelmäßige Health-Checks (Cronjob)
     * - Admin-Panel "System-Check"
     * - CI/CD Pipeline Integration
     * 
     * Beispiele:
     * ```php
     * // Alle installierten Module prüfen
     * $report = bx_dependency_resolver::validateProjects([
     *     'modified_qrcode',
     *     'modified_tcpdf', 
     *     'modified_barcode'
     * ]);
     * 
     * if (!$report['valid']) {
     *     echo "WARNUNG: Konflikte erkannt!\n";
     *     foreach ($report['conflicts'] as $conflict) {
     *         echo "- {$conflict['message']}\n";
     *     }
     * }
     * 
     * // Admin-Panel Check
     * if ($admin_check) {
     *     $all_modules = scanModules(); // Deine Funktion
     *     $report = bx_dependency_resolver::validateProjects($all_modules);
     *     if (!$report['valid']) {
     *         showAdminWarning($report['conflicts']);
     *     }
     * }
     * ```
     * 
     * @param array $project_names Array mit Projekt-Namen zum Validieren
     *                             Beispiel: ['modified_qrcode', 'modified_tcpdf']
     * 
     * @return array Validation-Report mit folgender Struktur:
     *               [
     *                   'valid' => bool,              // true = keine Konflikte
     *                   'projects_checked' => int,     // Anzahl geprüfter Projekte
     *                   'conflicts' => [               // Array aller gefundenen Konflikte
     *                       [
     *                           'type' => 'major_conflict',
     *                           'package' => 'guzzlehttp/guzzle',
     *                           'loaded_version' => '6.5.0',
     *                           'required_version' => '7.8.0',
     *                           'loaded_by' => 'projekt_a',
     *                           'required_by' => 'projekt_b',
     *                           'message' => 'Detailed error message'
     *                       ]
     *                   ],
     *                   'transitive_warnings' => [     // Transitive Dependency Warnings
     *                       [
     *                           'type' => 'transitive_conflict',
     *                           'severity' => 'warning',
     *                           'package' => 'symfony/console',
     *                           'requires' => 'psr/log',
     *                           'constraint' => '^3.0',
     *                           'loaded_version' => '1.1.0',
     *                           'loaded_by' => 'projekt_x',
     *                           'message' => 'Human-readable description'
     *                       ]
     *                   ]
     *               ]
     * 
     * @since 1.0
     * @see require() Normales Laden (wirft Exception bei Konflikt)
     * @see requireMultiple() Optimiertes Laden mehrerer Projekte
     */
    public static function validateProjects($project_names) { 
        self::init();
        
        // Security: Validiere alle Projekt-Namen
        foreach ($project_names as $project_name) {
            try {
                self::validateProjectName($project_name);
            } catch (BxInvalidProjectNameException | BxSecurityException $e) {
                // Bei Validierungs-Fehler direkt zurückgeben (kein Array-Access nötig)
                return [
                    'valid' => false,
                    'projects_checked' => 0,
                    'conflicts' => [[
                        'type' => 'invalid_project_name',
                        'severity' => 'critical',
                        'project' => $project_name,
                        'message' => $e->getMessage(),
                        'context' => $e->getContext()
                    ]],
                    'transitive_warnings' => []
                ];
            }
        }
        
        if (empty($project_names)) {
            return [
                'valid' => true,
                'projects_checked' => 0,
                'conflicts' => []
            ];
        }
        
        self::log("Validating projects: " . implode(', ', $project_names), 'INFO');        
        // Registry laden
        if (self::$package_registry === null) {
            self::$package_registry = self::buildRegistry();
        }
        
        $conflicts = [];
        $simulated_loaded = []; // Simuliert geladene Projekte
        
        // Optimale Lade-Reihenfolge ermitteln (wie requireMultiple)
        $optimized_order = self::optimizeLoadOrder($project_names);
        
        self::debug("Validating projects in order: " . implode(', ', $optimized_order));
        
        // Simuliere Laden jedes Projekts
        foreach ($optimized_order as $project_name) {
            $project_path = self::$base_path . $project_name . '/';
            
            // Prüfe ob Projekt existiert
            if (!is_dir($project_path)) {
                $conflicts[] = [
                    'type' => 'project_not_found',
                    'project' => $project_name,
                    'message' => "Project '{$project_name}' not found in " . self::$base_path
                ];
                continue;
            }
            
            // Hole Packages dieses Projekts
            $packages = self::getProjectPackages($project_name);
            
            if (empty($packages)) {
                $conflicts[] = [
                    'type' => 'no_packages',
                    'project' => $project_name,
                    'message' => "No packages found for project '{$project_name}'"
                ];
                continue;
            }
            
            // Prüfe jedes Package gegen bereits "geladene"
            foreach ($packages as $package_name => $version) {
                $conflict = self::detectConflict($package_name, $version, $project_name, $simulated_loaded);
                if ($conflict !== null) {
                    $conflicts[] = $conflict;
                }
            }
            
            // Füge Projekt zu simuliert geladenen hinzu
            $simulated_loaded[$project_name] = [
                'packages' => $packages
            ];
        }
        
        // Transitive Dependencies validieren (für bereits geladene Projekte)
        $transitive_warnings = [];
        
        // Temporär geladene Projekte simulieren für transitive Validierung
        $original_loaded = self::$loaded_projects;
        self::$loaded_projects = $simulated_loaded;
        
        foreach ($simulated_loaded as $project_name => $project_info) {
            $warnings = self::validateTransitiveDependencies($project_name);
            foreach ($warnings as $warning) {
                $transitive_warnings[] = $warning; // Direktes Append
            }
        }
        
        // Original State wiederherstellen
        self::$loaded_projects = $original_loaded;
        
        $is_valid = empty($conflicts);
        $has_warnings = !empty($transitive_warnings);
        
        self::debug("Validation complete: " . ($is_valid ? "✓ VALID" : "✗ CONFLICTS FOUND"));
        self::log("Validation complete: " . count($conflicts) . " conflicts, " . count($transitive_warnings) . " warnings", 
                  $is_valid ? 'INFO' : 'WARNING');
        
        if ($has_warnings) {
            self::debug("⚠ Transitive dependency warnings: " . count($transitive_warnings));
        }
        
        return [
            'valid' => $is_valid,
            'projects_checked' => count($project_names),
            'conflicts' => $conflicts,
            'transitive_warnings' => $transitive_warnings
        ];
    }
    
    /**
     * Prüft ob eine Version einen Composer-Constraint erfüllt
     * 
     * Diese Methode nutzt die offizielle composer/semver Library für vollständige
     * Kompatibilität mit Composer's Version-Constraint-Format.
     * 
     * Unterstützte Constraint-Formate (alle offiziellen Composer-Formate):
     * - OR-Constraints (||): ^1.1 || ^2.0
     * - AND-Constraints: >=1.0 <2.0
     * - Caret (^): ^7.0, ^7.5
     * - Tilde (~): ~7.5, ~7.5.2
     * - Comparison: >=7.0, >7.0, <=7.0, <7.0, =7.0
     * - Wildcard: 7.5.*, 7.*
     * - Exakte Version: 7.5.0
     * - Hyphen Range: 1.0 - 2.0
     * - Alle weiteren Composer-spezifischen Formate
     * 
     * Beispiele:
     * ```php
     * satisfiesConstraint('7.8.0', '^7.0');           // true
     * satisfiesConstraint('2.0.0', '^1.1 || ^2.0');   // true
     * satisfiesConstraint('1.5.0', '>=1.0 <2.0');     // true
     * ```
     * 
     * @param string $version Version zum Prüfen (z.B. '7.8.0')
     * @param string $constraint Composer-Constraint (z.B. '^7.0', '~7.5', '>=7.0')
     * @return bool True wenn Version den Constraint erfüllt
     * @since 1.0
     * @see validateTransitiveDependencies() Nutzt diese Methode
     */
    private static function satisfiesConstraint($version, $constraint) {
        // modified_semver Projekt laden (falls noch nicht geschehen)
        static $semver_available = null;
        
        if ($semver_available === null) {
            try {
                self::require('modified_semver');
                $semver_available = class_exists('\Composer\Semver\Semver');
            } catch (Exception $e) {
                self::debug("modified_semver not available: " . $e->getMessage());
                $semver_available = false;
            }
        }
        
        // Composer Semver nutzen (beste Option)
        if ($semver_available) {
            try {
                // Semver normalisiert Version intern - NICHT vorher normalisieren!
                return \Composer\Semver\Semver::satisfies($version, trim($constraint));
            } catch (\Exception $e) {
                // Bei Parse-Fehler (ungültiger Constraint): Fallback
                self::debug("Semver parse error for '{$constraint}': " . $e->getMessage());
            }
        }
        
        // Fallback: Einfacher Versions-Vergleich
        // Hinweis: Unterstützt nur einfache Formate, keine komplexen Constraints wie ^7.0
        $normalized_version = self::normalizeVersion($version);
        
        // Entferne Constraint-Operatoren für simplen Vergleich
        $constraint = trim($constraint);
        if (preg_match('/^[><=]+\s*(.+)$/', $constraint, $matches)) {
            // Hat bereits Operator (>=7.0, <8.0, etc.)
            $constraint_version = $matches[1];
        } else {
            // Keine Operator - behandle als ">=" (z.B. "7.0" -> ">=7.0")
            $constraint_version = $constraint;
        }
        
        return version_compare($normalized_version, self::normalizeVersion($constraint_version), '>=');
    }
    
    /**
     * Validiert transitive Dependencies eines geladenen Projekts
     * 
     * Diese Methode prüft, ob die geladenen Packages die Requirements ihrer
     * eigenen Dependencies (transitive Dependencies) erfüllen. Sie analysiert
     * die 'requires' Informationen aus der composer.lock und validiert gegen
     * die tatsächlich geladenen Versionen.
     * 
     * Funktionsweise:
     * 1. Iteriert über alle Packages des Projekts
     * 2. Holt Requirements (requires) jedes Packages aus der Registry
     * 3. Prüft für jedes Requirement, ob die geladene Version kompatibel ist
     * 4. Nutzt satisfiesConstraint() für Composer-Constraint-Validierung
     * 5. Sammelt alle Warnings (nicht-kritische Hinweise)
     * 
     * Unterschied zu checkConflict():
     * - checkConflict(): Prüft direkte Version-Konflikte zwischen Projekten
     * - validateTransitiveDependencies(): Prüft ob Package-Requirements erfüllt sind
     * 
     * Beispiel-Szenario:
     * ```
     * Projekt A lädt:
     * - symfony/console 6.4.0 (requires: psr/log ^3.0)
     * - psr/log 1.1.0 (von anderem Projekt)
     * 
     * → Warning: symfony/console requires psr/log ^3.0, but 1.1.0 is loaded
     * ```
     * 
     * Warum nur Warnings?
     * Composer selbst hat diese Packages bereits aufgelöst und installiert.
     * Wenn hier Mismatches auftreten, liegt es an unterschiedlichen Projekten
     * mit verschiedenen composer.lock Zuständen. Diese sind meist nicht-kritisch,
     * sollten aber dokumentiert werden.
     * 
     * Verwendung:
     * Wird von validateProjects() automatisch aufgerufen, um umfassende
     * Dependency-Analyse zu bieten.
     * 
     * @param string $project_name Name des zu validierenden Projekts
     * @return array Array mit Warnings, leer wenn alles OK
     *               Struktur pro Warning:
     *               [
     *                   'type' => 'transitive_conflict',
     *                   'package' => 'symfony/console',
     *                   'requires' => 'psr/log',
     *                   'constraint' => '^3.0',
     *                   'loaded_version' => '1.1.0',
     *                   'loaded_by' => 'projekt_x',
     *                   'message' => 'Human-readable description'
     *               ]
     * @since 1.0
     * @see validateProjects() Ruft diese Methode automatisch auf
     * @see satisfiesConstraint() Für Constraint-Validierung
     */
    private static function validateTransitiveDependencies($project_name) {
        $packages = self::getProjectPackages($project_name);
        $warnings = [];
        
        foreach ($packages as $package_name => $version) {
            // Hole Requirements dieses Packages aus Registry
            $package_info = self::getPackageInfo($package_name);
            if (!$package_info) continue;
            
            // Finde das richtige Projekt-Entry
            $pkg_data = null;
            foreach ($package_info as $info) {
                if ($info['project'] === $project_name) {
                    $pkg_data = $info;
                    break;
                }
            }
            
            if (!$pkg_data || empty($pkg_data['requires'])) continue;
            
            // Prüfe jedes Requirement
            foreach ($pkg_data['requires'] as $required_pkg => $constraint) {
                // PHP-Constraint und ext-* überspringen
                if ($required_pkg === 'php' || strpos($required_pkg, 'ext-') === 0) {
                    continue;
                }
                
                // Prüfe ob Required-Package in einem geladenen Projekt vorhanden ist
                foreach (self::$loaded_projects as $loaded_name => $loaded_info) {
                    if (isset($loaded_info['packages'][$required_pkg])) {
                        $loaded_version = $loaded_info['packages'][$required_pkg];
                        
                        // Constraint-Prüfung
                        if (!self::satisfiesConstraint($loaded_version, $constraint)) {
                            $warnings[] = [
                                'type' => 'transitive_conflict',
                                'severity' => 'warning',
                                'package' => $package_name,
                                'requires' => $required_pkg,
                                'constraint' => $constraint,
                                'loaded_version' => $loaded_version,
                                'loaded_by' => $loaded_name,
                                'message' => "Transitive dependency mismatch:<br>" . 
                                             "Package '{$package_name}' requires '{$required_pkg}' {$constraint},<br>" .
                                             "but version {$loaded_version} is loaded from '{$loaded_name}'"
                            ];
                        }
                        break; // Nur erste Übereinstimmung prüfen
                    }
                }
            }
        }
        
        return $warnings;
    }
    
    /**
     * Erstellt einen Abhängigkeits-Graphen aller geladenen Projekte
     * 
     * Diese Methode analysiert die Dependency-Struktur aller geladenen Projekte
     * und erstellt einen Graph, der zeigt, welches Projekt welche Packages nutzt
     * und welche Dependencies diese Packages haben.
     * 
     * Der Graph ist nützlich für:
     * - Visualisierung der Projekt-Abhängigkeiten
     * - Debugging komplexer Dependency-Chains
     * - Dokumentation der System-Architektur
     * - Admin-Panel Darstellung
     * - Erkennung von circular Dependencies
     * 
     * Graph-Struktur:
     * ```php
     * [
     *     'projekt_name' => [
     *         'packages' => [
     *             'guzzlehttp/guzzle' => [
     *                 'version' => '7.8.0',
     *                 'requires' => [
     *                     'psr/http-message' => '^2.0',
     *                     'guzzlehttp/psr7' => '^2.5'
     *                 ]
     *             ],
     *             'symfony/console' => [...]
     *         ],
     *         'dependencies' => [
     *             'psr/http-message',
     *             'guzzlehttp/psr7',
     *             'symfony/polyfill-mbstring'
     *         ]
     *     ]
     * ]
     * ```
     * 
     * Beispiel-Verwendung:
     * ```php
     * // Graph erstellen
     * $graph = bx_dependency_resolver::getDependencyGraph();
     * 
     * // Alle Dependencies eines Projekts anzeigen
     * foreach ($graph['modified_qrcode']['dependencies'] as $dep) {
     *     echo "- Abhängigkeit: {$dep}\n";
     * }
     * 
     * // Package-Details anzeigen
     * foreach ($graph['modified_qrcode']['packages'] as $pkg => $details) {
     *     echo "{$pkg} v{$details['version']}\n";
     *     foreach ($details['requires'] as $req => $constraint) {
     *         echo "  → benötigt: {$req} {$constraint}\n";
     *     }
     * }
     * 
     * // Circular Dependencies finden (vereinfacht)
     * foreach ($graph as $project => $data) {
     *     foreach ($data['dependencies'] as $dep) {
     *         if (isset($graph[$dep])) {
     *             echo "Circular: {$project} ↔ {$dep}\n";
     *         }
     *     }
     * }
     * ```
     * 
     * Visualisierungs-Ideen:
     * - Graphviz DOT Export für Diagramme
     * - D3.js Graph für interaktive Darstellung
     * - Admin-Panel Tree-View
     * - Markdown Dependency-Report
     * 
     * @return array Dependency-Graph aller geladenen Projekte
     * @since 1.0
     * @see getLoadedProjects() Für Liste der analysierten Projekte
     */
    public static function getDependencyGraph() {
        self::init();
        
        $graph = [];
        
        foreach (self::$loaded_projects as $project_name => $project_info) {
            $graph[$project_name] = [
                'packages' => [],
                'dependencies' => []
            ];
            
            foreach ($project_info['packages'] as $pkg_name => $version) {
                $pkg_info = self::getPackageInfo($pkg_name);
                
                if ($pkg_info) {
                    foreach ($pkg_info as $info) {
                        if ($info['project'] === $project_name) {
                            $graph[$project_name]['packages'][$pkg_name] = [
                                'version' => $version,
                                'requires' => $info['requires'] ?? []
                            ];
                            
                            // Extrahiere Package-Namen der Dependencies
                            foreach ($info['requires'] ?? [] as $req_pkg => $constraint) {
                                // PHP und Extensions überspringen
                                if ($req_pkg !== 'php' && strpos($req_pkg, 'ext-') !== 0) {
                                    if (!in_array($req_pkg, $graph[$project_name]['dependencies'])) {
                                        $graph[$project_name]['dependencies'][] = $req_pkg;
                                    }
                                }
                            }
                            break;
                        }
                    }
                }
            }
        }
        
        return $graph;
    }
    
    /**
     * Exportiert den Dependency-Graph als Graphviz DOT-Format
     * 
     * Erstellt eine DOT-Datei für Visualisierung mit Graphviz-Tools.
     * Unterstützt verschiedene Graph-Typen und Styling-Optionen.
     * 
     * Features:
     * - Project-Level Graph (Welches Projekt hängt von welchem ab)
     * - Package-Level Graph (Welche Packages werden von welchen Projekten genutzt)
     * - Farbcodierung für geladene/nicht-geladene Projekte
     * - Metadaten (Versionen, Package-Count)
     * - Cluster für bessere Übersicht
     * 
     * Verwendung:
     * ```php
     * // DOT-String generieren
     * $dot = bx_dependency_resolver::exportDependencyGraphDOT();
     * file_put_contents('dependencies.dot', $dot);
     * 
     * // Mit Graphviz visualisieren:
     * // dot -Tpng dependencies.dot -o dependencies.png
     * // dot -Tsvg dependencies.dot -o dependencies.svg
     * ```
     * 
     * @param string $type Graph-Typ: 'project' (Projekt-Dependencies) oder 'package' (Package-Usage)
     * @param bool $include_versions Versionen in Labels anzeigen
     * @return string DOT-Format String
     * @since 1.0
     */
    public static function exportDependencyGraphDOT($type = 'project', $include_versions = true) {
        self::init();
        
        $graph = self::getDependencyGraph();
        $loaded = self::getLoadedProjects();
        
        if ($type === 'project') {
            return self::exportProjectGraphDOT($graph, $loaded, $include_versions);
        } else {
            return self::exportPackageGraphDOT($graph, $loaded, $include_versions);
        }
    }
    
    /**
     * Exportiert Project-Level Dependency-Graph als DOT
     * 
     * Zeigt welche Projekte von welchen anderen Projekten abhängen
     * (über gemeinsame Package-Dependencies).
     * 
     * @param array $graph Dependency-Graph
     * @param array $loaded Liste geladener Projekte
     * @param bool $include_versions Versionen anzeigen
     * @return string DOT-Format
     */
    private static function exportProjectGraphDOT($graph, $loaded, $include_versions) {
        $dot = "digraph project_dependencies {\n";
        $dot .= "  // Graph-Einstellungen\n";
        $dot .= "  rankdir=LR;\n";
        $dot .= "  node [shape=box, style=rounded];\n";
        $dot .= "  graph [fontname=\"Arial\", fontsize=12];\n";
        $dot .= "  node [fontname=\"Arial\", fontsize=10];\n";
        $dot .= "  edge [fontname=\"Arial\", fontsize=8];\n\n";
        
        // Projekte als Nodes
        $dot .= "  // Projekte\n";
        foreach ($graph as $project => $data) {
            $is_loaded = in_array($project, $loaded);
            $package_count = count($data['packages']);
            
            $color = $is_loaded ? 'lightgreen' : 'lightblue';
            $label = $project;
            if ($include_versions) {
                $label .= "\\n({$package_count} packages)";
            }
            $status = $is_loaded ? 'loaded' : 'available';
            
            $dot .= "  \"{$project}\" [label=\"{$label}\", fillcolor=\"{$color}\", style=\"filled,rounded\", tooltip=\"{$status}\"];\n";
        }
        
        $dot .= "\n  // Dependencies\n";
        
        // Dependencies als Edges (basierend auf gemeinsamen Packages)
        $dependencies_added = [];
        foreach ($graph as $project => $data) {
            foreach ($data['dependencies'] as $dep_package) {
                // Finde welche anderen Projekte dieses Package bereitstellen
                foreach ($graph as $other_project => $other_data) {
                    if ($other_project !== $project && isset($other_data['packages'][$dep_package])) {
                        $edge_key = "{$project} -> {$other_project}";
                        if (!isset($dependencies_added[$edge_key])) {
                            $version = $other_data['packages'][$dep_package]['version'] ?? '';
                            $label = $include_versions && $version ? $dep_package . "\\n" . $version : $dep_package;
                            
                            $dot .= "  \"{$project}\" -> \"{$other_project}\" [label=\"{$label}\", tooltip=\"{$dep_package}\"];\n";
                            $dependencies_added[$edge_key] = true;
                        }
                    }
                }
            }
        }
        
        $dot .= "}\n";
        return $dot;
    }
    
    /**
     * Exportiert Package-Level Dependency-Graph als DOT
     * 
     * Zeigt welche Projekte welche Packages verwenden.
     * Nützlich für Package-Conflict-Analyse.
     * 
     * @param array $graph Dependency-Graph
     * @param array $loaded Liste geladener Projekte
     * @param bool $include_versions Versionen anzeigen
     * @return string DOT-Format
     */
    private static function exportPackageGraphDOT($graph, $loaded, $include_versions) {
        $dot = "digraph package_dependencies {\n";
        $dot .= "  // Graph-Einstellungen\n";
        $dot .= "  rankdir=LR;\n";
        $dot .= "  graph [fontname=\"Arial\", fontsize=12];\n";
        $dot .= "  node [fontname=\"Arial\", fontsize=10];\n";
        $dot .= "  edge [fontname=\"Arial\", fontsize=8];\n\n";
        
        // Cluster für Projekte und Packages
        $dot .= "  // Projekte (links)\n";
        $dot .= "  subgraph cluster_projects {\n";
        $dot .= "    label=\"Projekte\";\n";
        $dot .= "    style=filled;\n";
        $dot .= "    fillcolor=lightgrey;\n\n";
        
        foreach ($graph as $project => $data) {
            $is_loaded = in_array($project, $loaded);
            $color = $is_loaded ? 'lightgreen' : 'lightblue';
            $package_count = count($data['packages']);
            
            $dot .= "    \"proj_{$project}\" [label=\"{$project}\\n({$package_count})\", shape=box, style=\"filled,rounded\", fillcolor=\"{$color}\"];\n";
        }
        
        $dot .= "  }\n\n";
        
        // Sammle alle unique Packages
        $all_packages = [];
        foreach ($graph as $project => $data) {
            foreach ($data['packages'] as $pkg => $pkg_data) {
                if (!isset($all_packages[$pkg])) {
                    $all_packages[$pkg] = [];
                }
                $all_packages[$pkg][] = [
                    'project' => $project,
                    'version' => $pkg_data['version'] ?? ''
                ];
            }
        }
        
        $dot .= "  // Packages (rechts)\n";
        $dot .= "  subgraph cluster_packages {\n";
        $dot .= "    label=\"Packages\";\n";
        $dot .= "    style=filled;\n";
        $dot .= "    fillcolor=lightyellow;\n\n";
        
        foreach ($all_packages as $pkg => $projects) {
            $usage_count = count($projects);
            $has_conflicts = $usage_count > 1;
            $color = $has_conflicts ? 'orange' : 'white';
            
            $label = $pkg;
            if ($include_versions && $usage_count === 1) {
                $label .= "\\n" . $projects[0]['version'];
            } elseif ($has_conflicts) {
                $label .= "\\n(CONFLICT)";
            }
            
            $dot .= "    \"pkg_{$pkg}\" [label=\"{$label}\", shape=ellipse, style=filled, fillcolor=\"{$color}\"];\n";
        }
        
        $dot .= "  }\n\n";
        
        // Edges: Projekt -> Package
        $dot .= "  // Projekt -> Package Beziehungen\n";
        foreach ($graph as $project => $data) {
            foreach ($data['packages'] as $pkg => $pkg_data) {
                $version = $pkg_data['version'] ?? '';
                $label = $include_versions && $version ? $version : '';
                
                $dot .= "  \"proj_{$project}\" -> \"pkg_{$pkg}\"";
                if ($label) {
                    $dot .= " [label=\"{$label}\"]";
                }
                $dot .= ";\n";
            }
        }
        
        $dot .= "}\n";
        return $dot;
    }
    
    /**
     * Exportiert Dependency-Graph als Mermaid-Format
     * 
     * Mermaid ist ideal für Markdown-Dokumentation und moderne Tools
     * wie GitHub, GitLab, VS Code, etc.
     * 
     * Verwendung:
     * ```php
     * $mermaid = bx_dependency_resolver::exportDependencyGraphMermaid();
     * file_put_contents('README.md', "```mermaid\n{$mermaid}\n```");
     * ```
     * 
     * @param string $type Graph-Typ: 'project' oder 'package'
     * @return string Mermaid-Format String
     * @since 1.0
     */
    public static function exportDependencyGraphMermaid($type = 'project') {
        self::init();
        
        $graph = self::getDependencyGraph();
        $loaded = self::getLoadedProjects();
        
        if ($type === 'project') {
            $mermaid = "graph LR\n";
            $mermaid .= "  %% Projekt-Dependencies\n\n";
            
            // Projekte mit Styling
            foreach ($graph as $project => $data) {
                $is_loaded = in_array($project, $loaded);
                $style = $is_loaded ? ':::loaded' : ':::available';
                $safe_name = str_replace(['-', '.'], '_', $project);
                
                $mermaid .= "  {$safe_name}[\"{$project}\"]" . $style . "\n";
            }
            
            $mermaid .= "\n  %% Dependencies\n";
            
            // Dependencies
            foreach ($graph as $project => $data) {
                $safe_project = str_replace(['-', '.'], '_', $project);
                
                foreach ($data['dependencies'] as $dep) {
                    // Finde Projekt das dieses Package bereitstellt
                    foreach ($graph as $other_project => $other_data) {
                        if (isset($other_data['packages'][$dep])) {
                            $safe_other = str_replace(['-', '.'], '_', $other_project);
                            $mermaid .= "  {$safe_project} -->|{$dep}| {$safe_other}\n";
                            break;
                        }
                    }
                }
            }
            
            // Styling
            $mermaid .= "\n  %% Styling\n";
            $mermaid .= "  classDef loaded fill:#90EE90,stroke:#333,stroke-width:2px\n";
            $mermaid .= "  classDef available fill:#ADD8E6,stroke:#333,stroke-width:1px\n";
            
        } else {
            // Package-Graph
            $mermaid = "graph LR\n";
            $mermaid .= "  %% Package-Dependencies\n\n";
            
            foreach ($graph as $project => $data) {
                $safe_project = str_replace(['-', '.'], '_', $project);
                
                foreach ($data['packages'] as $pkg => $pkg_data) {
                    $safe_pkg = str_replace(['/', '-', '.'], '_', $pkg);
                    $version = $pkg_data['version'] ?? '';
                    
                    $mermaid .= "  {$safe_project}[\"{$project}\"] --> {$safe_pkg}((\"{$pkg}\\n{$version}\"))\n";
                }
            }
        }
        
        return $mermaid;
    }
    
    /**
     * Exportiert Dependency-Graph als JSON
     * 
     * Strukturiertes Format für weitere Verarbeitung, APIs, etc.
     * 
     * @param bool $pretty Pretty-Print JSON
     * @return string JSON-String
     * @since 1.0
     */
    public static function exportDependencyGraphJSON($pretty = true) {
        self::init();
        
        $graph = self::getDependencyGraph();
        $loaded = self::getLoadedProjects();
        
        $export = [
            'metadata' => [
                'generated_at' => date('Y-m-d H:i:s'),
                'total_projects' => count($graph),
                'loaded_projects' => count($loaded)
            ],
            'projects' => []
        ];
        
        foreach ($graph as $project => $data) {
            $export['projects'][$project] = [
                'status' => in_array($project, $loaded) ? 'loaded' : 'available',
                'package_count' => count($data['packages']),
                'packages' => $data['packages'],
                'dependencies' => $data['dependencies']
            ];
        }
        
        $flags = $pretty ? JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES : 0;
        return json_encode($export, $flags);
    }
    
    /**
     * Erkennt Package-Konflikte für Validation (ohne Exception zu werfen)
     * 
     * Diese Methode ist das Pendant zu checkConflict(), wird aber für den
     * Smoke-Test verwendet. Statt Exceptions zu werfen, gibt sie strukturierte
     * Konflikt-Informationen zurück.
     * 
     * Erkannte Konflikt-Typen:
     * - major_conflict: Unterschiedliche Major-Versionen (kritisch)
     * - version_too_low: Geladene Version niedriger als benötigte
     * 
     * Verwendung:
     * Wird ausschließlich von validateProjects() genutzt, um ALLE Konflikte
     * zu sammeln, statt beim ersten Konflikt abzubrechen.
     * 
     * Rückgabe-Struktur bei Konflikt:
     * ```php
     * [
     *     'type' => 'major_conflict',
     *     'severity' => 'critical',
     *     'package' => 'guzzlehttp/guzzle',
     *     'loaded_version' => '6.5.0',
     *     'required_version' => '7.8.0',
     *     'loaded_by' => 'projekt_a',
     *     'required_by' => 'projekt_b',
     *     'message' => 'Human-readable error message'
     * ]
     * ```
     * 
     * @param string $package_name Package-Name zum Prüfen (z.B. 'guzzlehttp/guzzle')
     * @param string $version Benötigte Version
     * @param string $project_name Projekt, das diese Version benötigt
     * @param array $simulated_loaded Simuliert geladene Projekte mit ihren Packages
     * @return array|null Konflikt-Info Array bei Konflikt, null wenn kompatibel
     * @since 1.0
     * @see validateProjects() Nutzt diese Methode für Smoke-Tests
     * @see checkConflict() Ähnliche Logik, aber mit Exceptions für echtes Laden
     */
    private static function detectConflict($package_name, $version, $project_name, $simulated_loaded) {
        foreach ($simulated_loaded as $loaded_name => $loaded_info) {
            if (isset($loaded_info['packages'][$package_name])) {
                $loaded_version = $loaded_info['packages'][$package_name];
                
                $version_norm = self::normalizeVersion($version);
                $loaded_norm = self::normalizeVersion($loaded_version);
                
                if ($version_norm !== $loaded_norm) {
                    $loaded_major = self::getMajorVersion($loaded_norm);
                    $required_major = self::getMajorVersion($version_norm);
                    
                    // Major-Version-Konflikt
                    if ($loaded_major !== $required_major) {
                        return [
                            'type' => 'major_conflict',
                            'severity' => 'critical',
                            'package' => $package_name,
                            'loaded_version' => $loaded_version,
                            'required_version' => $version,
                            'loaded_by' => $loaded_name,
                            'required_by' => $project_name,
                            'message' => "Major version conflict: {$package_name} - " .
                                       "v{$loaded_major}.x (from {$loaded_name}) vs " .
                                       "v{$required_major}.x (needed by {$project_name})"
                        ];
                    }
                    
                    // Niedrigere Version geladen
                    if (version_compare($loaded_norm, $version_norm) < 0) {
                        return [
                            'type' => 'version_too_low',
                            'severity' => 'error',
                            'package' => $package_name,
                            'loaded_version' => $loaded_version,
                            'required_version' => $version,
                            'loaded_by' => $loaded_name,
                            'required_by' => $project_name,
                            'message' => "Version conflict: {$package_name} - " .
                                       "{$loaded_version} loaded (from {$loaded_name}), " .
                                       "but {$version} required by {$project_name}"
                        ];
                    }
                }
            }
        }
        
        return null; // Kein Konflikt
    }
    
    // ========================================
    // Logging
    // ========================================
    
    /**
     * Rotiert die Log-Datei wenn sie zu groß wird
     * 
     * Diese Methode wird automatisch bei jedem Log-Schreibvorgang aufgerufen.
     * 
     * Rotation-Logik:
     * 1. Prüft ob Log-Datei über max_size liegt (Standard: 10MB)
     * 2. Benennt aktuelle Log-Datei mit Timestamp um (dependency_resolver.log.YYYY-MM-DD-HHmmss)
     * 3. Löscht alte Backup-Logs älter als retention-Zeit (Standard: 30 Tage)
     * 
     * Konfiguration:
     * - self::$log_max_size (Standard: 10MB)
     * - self::$log_backup_retention (Standard: 30 Tage)
     * 
     * Thread-Safety:
     * - Nutzt @ Suppression um Race-Conditions bei filesize() zu vermeiden
     * - rename() ist atomic auf den meisten Filesystemen
     * 
     * @return void
     */
    private static function rotateLogIfNeeded() {
        // Prüfe ob Log-Datei existiert und zu groß ist
        if (!file_exists(self::$log_path)) {
            return; // Log-Datei existiert nicht
        }
        
        $current_size = @filesize(self::$log_path);
        if ($current_size === false || $current_size < self::$log_max_size) {
            return; // Keine Rotation nötig
        }
        
        // Erstelle Backup-Dateinamen mit Timestamp
        $backup_name = self::$log_path . '.' . date('Y-m-d-His');
        
        // Rotiere Log-Datei (atomic operation)
        if (@rename(self::$log_path, $backup_name)) {
            // Rotation erfolgreich - bereinige alte Backups
            $retention_time = time() - self::$log_backup_retention;
            $pattern = self::$log_path . '.*';
            
            foreach (glob($pattern) as $old_log) {
                // Prüfe Alter der Backup-Datei
                $mtime = @filemtime($old_log);
                if ($mtime !== false && $mtime < $retention_time) {
                    @unlink($old_log);
                }
            }
        }
        // Bei Fehler wird nächster Log-Schreibvorgang es erneut versuchen
    }
    
    /**
     * Schreibt eine Log-Nachricht in die Log-Datei
     * 
     * Format: [YYYY-MM-DD HH:MM:SS] [LEVEL] [PROJECT] Message
     * 
     * @param string $message Log-Nachricht
     * @param string $level Log-Level: DEBUG, INFO, WARNING, ERROR
     * @param string $project Optional: Projekt-Name
     * @return void
     */
    private static function log($message, $level = 'INFO', $project = '') {
        self::init();
        
        // Prüfe ob Logging aktiviert ist (Level-abhängig)
        $logging_enabled = false;
        
        // DEBUG-Level: Nur wenn DEBUG-Modus aktiv
        if ($level === 'DEBUG') {
            if (self::$debug) {
                $logging_enabled = true;
            }
        } else {
            // INFO/WARNING/ERROR: Wenn Debug ODER normales Logging aktiv
            if (self::$debug) {
                $logging_enabled = true;
            } elseif (defined('MODULE_BX_DEPENDENCY_LOGGING') && MODULE_BX_DEPENDENCY_LOGGING === 'true') {
                $logging_enabled = true;
            }
        }
        
        if (!$logging_enabled) {
            return;
        }
        
        // Rotiere Log-Datei falls nötig (vor dem Schreiben)
        self::rotateLogIfNeeded();
        
        $timestamp = date('Y-m-d H:i:s');
        $project_str = $project ? "[{$project}] " : '';
        $log_line = "[{$timestamp}] [{$level}] {$project_str}{$message}\n";
        
        // Schreibe in Log-Datei (atomic operation mit LOCK_EX)
        @file_put_contents(self::$log_path, $log_line, FILE_APPEND | LOCK_EX);
    }
}
