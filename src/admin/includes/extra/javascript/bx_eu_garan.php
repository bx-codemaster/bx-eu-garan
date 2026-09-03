<?php
/** 
 * ██████╗  ███████╗ ███╗   ██╗  █████╗  ██╗  ██╗
 * ██╔══██╗ ██╔════╝ ████╗  ██║ ██╔══██╗ ╚██╗██╔╝
 * ██████╔╝ █████╗   ██╔██╗ ██║ ███████║  ╚███╔╝
 * ██╔══██╗ ██╔══╝   ██║╚██╗██║ ██╔══██║  ██╔██╗
 * ██████╔╝ ███████╗ ██║ ╚████║ ██║  ██║ ██╔╝ ██╗
 * ╚═════╝  ╚══════╝ ╚═╝  ╚═══╝ ╚═╝  ╚═╝ ╚═╝  ╚═╝
 * BX EU Garan - JavaScript
 * 
 * @package    BX EU Garan
 * @subpackage JavaScript
 * @category   Admin
 * @author     Axel Benkert
 * @version    1.2.5
 * @since      1.0.0
 * @date       2025-11-09
 * @copyright  2020-2026 Axel Benkert
 * @license    GNU General Public License
 */

 defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

 if ( defined('MODULE_BX_EU_GARAN_STATUS') && 
      MODULE_BX_EU_GARAN_STATUS == 'True' && 
      (basename($_SERVER['PHP_SELF']) == 'bx_eu_garan.php' || 
       basename($_SERVER['PHP_SELF']) == 'categories.php')) {
?>
<script>
  "use strict";
  document.addEventListener("DOMContentLoaded", function() {

    var setups = [
      { sliderId: "bx_eu_garan_repair_score", outputId: "repair_score_value" },
      { sliderId: "bx_eu_garan_availability_years", outputId: "availability_years_value" }
    ];

    setups.forEach(function(item) {
      var slider = document.getElementById(item.sliderId);
      var output = document.getElementById(item.outputId);
      
      if (slider && output) {
        output.textContent = slider.value;
        slider.addEventListener("input", function() {
          output.textContent = this.value;
        });
      }
    });

    // Findet alle <details>-Elemente mit der Klasse "store-state"
    const allDetails = document.querySelectorAll('details.store-state');

    allDetails.forEach(details => {
      // Erstellt einen eindeutigen Schlüssel für den localStorage, z.B. "detailsState_details-features"
      const storageKey = `detailsState_${details.id}`;

      // 1. Zustand beim Laden der Seite wiederherstellen
      const savedState = localStorage.getItem(storageKey);
      if (savedState === 'open') {
        details.setAttribute('open', 'true');
      } else if (savedState === 'closed') {
        details.removeAttribute('open');
      }

      // 2. Auf Änderungen reagieren und im localStorage speichern
      details.addEventListener('toggle', () => {
        if (details.open) {
          localStorage.setItem(storageKey, 'open');
        } else {
          localStorage.setItem(storageKey, 'closed');
        }
      });
    });
    // Tabs initialisieren
    document.querySelectorAll('.bx-tabs').forEach(container => {
      const nav = container.querySelector('.bx-tab-nav');

      if (!nav) {
          return;
      }

      const tabs = nav.querySelectorAll('.bx-tab');
      const contents = container.querySelectorAll('.bx-tab-content');

      const storageKey = 'activeTab_' + container.dataset.tabs;

      function activateTab(tab, save = true) {
        const targetId = tab.dataset.tab;
        const target = container.querySelector('#' + CSS.escape(targetId));

        if (!target) {
          return;
        }

        tabs.forEach(item => {
          const active = item === tab;

          item.classList.toggle('active', active);
          item.setAttribute('aria-selected', active ? 'true' : 'false');
        });

        contents.forEach(content => {
          content.classList.toggle('active', content === target);
        });

        if (save) {
          localStorage.setItem(storageKey, targetId);
        }
      }

      // Gespeicherten Tab wiederherstellen
      const savedTab = localStorage.getItem(storageKey);

      const initialTab =
          [...tabs].find(tab => tab.dataset.tab === savedTab) ||
          tabs[0];

      if (initialTab) {
        activateTab(initialTab, false);
      }

      // Tab-Navigation
      nav.addEventListener('click', event => {
        const tab = event.target.closest('.bx-tab');

        if (!tab || !nav.contains(tab)) {
            return;
        }

        activateTab(tab);
      });
    });

    // Öffnet oder schließt das Details-Element basierend auf dem Status des Kontrollkästchens "delete_filtered_entries"
    const checkbox = document.getElementById('delete_filtered_entries');
    const details  = document.querySelector('details.check_delete');

    if (checkbox && details) {
      // 1. Beim Laden der Seite
      if (checkbox.checked) {
        details.open = true;
      } else {
        details.open = false;
      }

      // 2. Auf spätere Klicks/Änderungen durch den Nutzer reagieren
      checkbox.addEventListener('change', function() {
        details.open = this.checked;
      });
    }

  });

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
      }, 5000);
    });
  }
  $(document).ready(autoHideFixedMessageStack);
</script>
<?php
 }
?>