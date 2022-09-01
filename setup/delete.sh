#!/usr/bin/env bash
_err() { printf '%s\n' "$(_color 160)Error:$(_color -1)" "$@"; exit 1; }
if [[ -n ${BASH_SOURCE[0]} ]]; then
  cd -P -- "$(dirname -- "${BASH_SOURCE[0]}")"
else
  cd -P -- "$(dirname -- "$0")"
fi
[[ ! -f app.env ]] && _err 'Please run setup first'
. app.env
docker compose down
sudo rm -rf "$PROJECT_HOME"

