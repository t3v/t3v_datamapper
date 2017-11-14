# ----------------------------
# | T3v DataMapper Constants |
# ----------------------------

# === Plugin Constants ===

plugin {
  tx_t3vdatamapper {
    persistence {
      # cat=plugin/tx_t3vdatamapper/persistence; type=boolean; label=Enables the automatic cache clearing when changing data sets
      enableAutomaticCacheClearing = 1

      # cat=plugin/tx_t3vdatamapper/persistence; type=int+; label=The PID of the storage
      storagePid = 0

      # cat=plugin/tx_t3vdatamapper/persistence; type=boolean; label=Updates reference index to ensure data integrity
      updateReferenceIndex = 1
    }

    settings {
      # cat=plugin/tx_t3vdatamapper/settings; type=boolean; label=If set, the language record (overlay) will be applied
      languageOverlay = 1
    }

    view {
      # cat=plugin/tx_t3vdatamapper/view; type=string; label=The default path to the layouts
      layoutRootPath = EXT:t3v_datamapper/Resources/Private/Layouts/

      # cat=plugin/tx_t3vdatamapper/view; type=string; label=The default path to the templates
      templateRootPath = EXT:t3v_datamapper/Resources/Private/Templates/

      # cat=plugin/tx_t3vdatamapper/view; type=string; label=The default path to the partials
      partialRootPath = EXT:t3v_datamapper/Resources/Private/Partials/
    }
  }
}