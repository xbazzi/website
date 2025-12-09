default:
    @just -l

prod:
	npm run prod

dev:
	npm run dev

deploy commit_msg: prod
	#!/usr/bin/env sh
	eval "$(ssh-agent -s)"
	ssh-add ~/.ssh/*
	git add -A 
	git commit -m "{{commit_msg}}"
	git push origin master
	

# Cleaning
clean:
	cargo clean

## Deep clean (including cache)
clean-all: clean
	rm -rf target/
	rm -rf ~/.cargo/registry/cache/

## Run benchmarks
bench: 
	cargo bench --workspace

## Profile the application (requires cargo-flamegraph)
profile: 
	cargo flamegraph -p waycast-ui
	brave flamegraph.svg