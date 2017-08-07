default: theme plugin

plugin:
	zip ppb-orgs.zip ppb-orgs

theme:
	zip ppb-magnus-child.zip ppb-magnus-child

clean:
	rm -f ppb-magnus-child.zip
	rm -f ppb-orgs.zip
