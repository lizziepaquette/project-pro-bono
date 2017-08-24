THEME = ppb-quotidian
PLUGIN = ppb-orgs

default: theme plugin

plugin:
	zip -r $(PLUGIN).zip $(PLUGIN)

theme:
	sass $(THEME)/assets/scss/style.scss $(THEME)/style.css
	zip -r $(THEME).zip $(THEME)

theme-watch:
	sass --watch $(THEME)/assets/scss/:$(THEME)/

clean:
	rm -f $(THEME).zip
	rm -f $(PLUGIN).zip

time:
	cat worklog.md | cut -s -d '|' -f 3 | tail -n +3 \
	| awk '{ sum+=$$1} END {print sum}'
