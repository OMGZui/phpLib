#!/usr/bin/env bash

time=$(date "+%Y-%m-%d %H:%M:%S")

git add .
git commit -m "$time"
git push origin master