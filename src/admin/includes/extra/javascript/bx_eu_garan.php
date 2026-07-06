<?php
/** 
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX Global Sort - JavaScript
 * 
 * jQuery UI Sortable Integration mit automatischer AJAX-Speicherung.
 * Enthält:
 * - Sortable-Konfiguration für Tabellen (tbody Drag & Drop)
 * - AJAX Auto-Save Funktion (saveSortOrder) mit Toast-Notifications
 * - Placeholder-Styling während des Dragging (7 Spalten)
 * - Automatische Sort-Order-Aktualisierung in Echtzeit
 * - Visuelles Feedback (saving/saved/error States)
 * - jQuery 1.8.3 kompatible POST-Request-Serialisierung
 * 
 * @package    BX Global Sort
 * @subpackage JavaScript
 * @category   Admin
 * @author     Axel Benkert
 * @version    1.2
 * @since      1.0.0
 * @date       2025-11-09
 * @copyright  2020-2025 Axel Benkert
 * @license    GNU General Public License
 * @requires   jQuery 1.8.3+, jQuery UI 1.12.1 
 */

 defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

 if (defined('MODULE_BX_EU_GARAN_STATUS') && MODULE_BX_EU_GARAN_STATUS == 'True' && basename($_SERVER['PHP_SELF']) == 'bx_eu_garan.php') {
?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script>
  "use strict";
  // Toast Notification Function
  function showToast(message, type) {
    type = type || 'success';
    var iconClass = type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle');
    
    var toast = $('<div class="bx-toast ' + type + '">' +
      '<i class="fas ' + iconClass + ' bx-toast-icon"></i>' +
      '<div class="bx-toast-message">' + message + '</div>' +
      '<span class="bx-toast-close">&times;</span>' +
    '</div>');
    
    $('body').append(toast);
    
    toast.find('.bx-toast-close').on('click', function() {
      toast.addClass('hiding');
      setTimeout(function() { toast.remove(); }, 300);
    });
    
    setTimeout(function() {
      toast.addClass('hiding');
      setTimeout(function() { toast.remove(); }, 300);
    }, 4000);
  }
  /**
   * Blendet die feste Message-Stack-Box kurz ein und automatisch wieder aus.
   * Diese kleine Komfortfunktion sorgt dafür, dass Statusmeldungen nach dem
   * Laden sichtbar sind, aber den Adminbereich nach kurzer Zeit wieder freigeben.
   *
   * @returns {void}
   */
  function autoHideFixedMessageStack() {
    $(".fixed_messageStack").slideDown("slow", function() {
      setTimeout(function() {
        $(".fixed_messageStack").slideUp("slow");
      }, 2000);
    });
  }
  $(document).ready(autoHideFixedMessageStack);
</script>
<?php
 }
?>