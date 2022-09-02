#!/usr/bin/env bash
_color() { if [[ $1 -eq -1 ]]; then printf '%b' '\e[0m'; else printf '%b' "\e[38;5;$1m"; fi; }
_log() { printf '%s\n' "$@" >&2; }
_err() { _log "$(_color 160)Error:$(_color -1)" "$@"; exit 1; }
_ask() {
  _log "Please enter value for required parameter $1"
  read -p "[${!1}]: " temp
  [[ ! "$temp" == "" ]] && export "$1"="$temp"
}
if [[ -n ${BASH_SOURCE[0]} ]]; then
  cd -P -- "$(dirname -- "${BASH_SOURCE[0]}")"
else
  cd -P -- "$(dirname -- "$0")"
fi
_ask HOME
export DOCKER_SOCK="$(sudo find /run -type s -name docker.sock)"
_ask DOCKER_SOCK
export DOCKER_GROUP="$(stat -c %g $DOCKER_SOCK)"
_ask DOCKER_GROUP
export COMPOSE_PROJECT_NAME='final_project'
export PROJECT_HOME="$HOME/.docker/$COMPOSE_PROJECT_NAME"
echo -e "export COMPOSE_PROJECT_NAME=\"$COMPOSE_PROJECT_NAME\"\nexport DOCKER_SOCK=\"$DOCKER_SOCK\"\nexport DOCKER_GROUP=\"$DOCKER_GROUP\"\nexport PROJECT_HOME=\"$PROJECT_HOME\"" > app.env
mkdir -p "$PROJECT_HOME"
for i in jenkins sonarqube sonarqubedb; do
  sudo cp -pr "$i" "$PROJECT_HOME"/"$i"
done
docker compose up -d

