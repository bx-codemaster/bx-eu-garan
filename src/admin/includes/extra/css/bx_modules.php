<?php
/**
 * Extra CSS für alle BX Module
 * Enthält zusätzliche CSS-Stile für alle BX-Module.

 * Additional CSS for all BX modules
 * Contains additional CSS styles for all BX modules.
 * 
 * @package bx-eu-garan
 */
  defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

  $allowed_pages = array(
      'bx_eu_garan.php',
      'categories.php',
      'start.php',
      'module_export.php'
  );
  
  if (defined('MODULE_BX_EU_GARAN_STATUS') && 
              MODULE_BX_EU_GARAN_STATUS == 'True' && 
              in_array(basename($_SERVER['PHP_SELF']), $allowed_pages)
      ) { 
?>
<style>
:root {
  --bx-primary: #AF417E;
  --bx-primary-hover: #d34e97;
  --bx-secondary: #a7b800;
  --bx-secondary-hover: #c1d201;
  --bx-white: #ffffff;
  --bx-bg-light-pink: #fef2f2;
  --bx-bg-input: #f8fafc;
  --bx-bg-card: #eceff3;
  --bx-text-main: #0f172a;
  --bx-text-muted: #64748b;
  --bx-border-color: #cbd5e1;
  --bx-border-accent: #c41e3a;
  --bx-radius: 6px;
  --bx-shadow-md: 0 6px 16px rgba(0, 0, 0, 0.06);
  --bx-shadow-lg: 0 18px 30px -14px rgba(15, 23, 42, 0.25);
  --bx-gradient-primary: linear-gradient(180deg, rgb(195, 101, 152) 0%, rgb(175, 65, 126) 55%, rgb(146, 46, 102) 100%);
  --bx-gradient-secondary: linear-gradient(180deg, rgb(193, 210, 1) 0%, rgb(167, 184, 0) 55%, rgb(139, 156, 0) 100%);
}

html {
  scrollbar-gutter: stable;
}

#headboard {
  display: flex; 
  flex-direction: row; 
  justify-content: flex-start;
  width: 100%;
  align-items: center; 
  background: var(--bx-gradient-primary); 
  color: var(--bx-white); 
  border-radius: 4px; 
  margin-bottom: 10px; 
  padding: 0;
  line-height: 30px;
  min-height: 40px;
}

#headboard .main {
  margin: 5px 10px;
}

#headboard .SumoSelect {
  color: #000;
}

#headboard .main input[type="text"].pd34 {
  padding: 3px 4px !important;
}

.bxac-card {
  position: relative;
  border: 1px solid var(--bx-border-color);
  border-radius: 6px;
  background: var(--bx-gradient-primary);
  box-shadow: var(--bx-shadow-md);
  margin: 5px 0;
  overflow: hidden;
}
.bx-card-hot {
  position: absolute;
  display: block;
  height: 1.75rem;
  width: auto;
  top: 0.5rem;
  right: -0.5rem;
  font-size: 1.5rem;
}
.bxac-summary {
  list-style: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 2px;
  padding: 0 2px;
  background: transparent;
  color: var(--bx-white);
  min-height: 36px;
}
.bxac-summary::-webkit-details-marker {
  display: none;
}
.bxac-arrow {
  transition: transform 0.2s ease;
  color: var(--bx-white);
  font-size: 30px;
  line-height: 30px;
}
.bxac-card[open] .bxac-arrow {
  transform: rotate(90deg);
}
.bxac-title {
  margin: 0;
  font-size: 12px;
  line-height: 1.4;
  font-weight: 700;
}
.bxac-body {
  padding: 5px;
  background: var(--bx-bg-card);
  border-left: 4px solid var(--bx-border-accent);
}
.bxac-body h4 {
  margin: 8px 0 6px;
  color: var(--bx-text-main);
}
.bxac-body ul {
  list-style-type: none;
  margin: 0 0 0 10px;
  padding: 0;
  line-height: 1.6;
}
.bxac-link {
  margin-top: 12px;
}
</style>
<?php
  }
?>