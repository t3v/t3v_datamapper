# === T3v DataMapper Constants ===

plugin {
  tx_t3vdatamapper {
    persistence {
      # cat=plugin/tx_t3vdatamapper/persistence; type=int+; label=The PID of the storage
      # storagePid = 0
    }

    view {
      # cat=plugin/tx_t3vdatamapper/view; type=string; label=Path to layouts
      layoutRootPath = EXT:t3v_datamapper/Resources/Private/Layouts/

      # cat=plugin/tx_t3vdatamapper/view; type=string; label=Path to templates
      templateRootPath = EXT:t3v_datamapper/Resources/Private/Templates/

      # cat=plugin/tx_t3vdatamapper/view; type=string; label=Path to template partials
      partialRootPath = EXT:t3v_datamapper/Resources/Private/Partials/
    }

    settings {
      # ...
    }
  }
}