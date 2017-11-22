THEME = ppb-quotidian
PLUGIN = ppb-orgs

.PHONY: all watch clean

all: $(PLUGIN).zip $(THEME).zip

$(PLUGIN).zip:
	zip -r $(PLUGIN).zip $(PLUGIN)

$(THEME).zip:
	sass $(THEME)/assets/scss/style.scss $(THEME)/style.css
	zip -r $(THEME).zip $(THEME)

watch:
	sass --watch $(THEME)/assets/scss/:$(THEME)/

clean:
	rm -rf $(THEME).zip
	rm -rf $(PLUGIN).zip
	rm -rf .sass-cache
