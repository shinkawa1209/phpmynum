# phpmynum
PurePHPで作ってDockerComposeで動かすマイナンバー占いセットです。
## 構成(以下が起動します)
- nginx
- php
- mysql5.7
## 実行環境
- Dockerがインストールされ、DockerComposeが使えるPCやサーバなど
- my.cnfやphp.iniファイルのパーミッションは環境に合わせてOSから設定してください。
## 実行手順
- 一式をローカルにCloneしてください。
- CloneしたディレクトリにあるSample.envをコピーし、ファイル名を.envに変更してください。
- Cloneしたディレクトリにて、以下のコマンドを実行してください。
```
docker compose up -d
```
- 環境によって、初回のみDB接続がクラッシュする場合があります。その場合は以下のコマンドで再度起動してください。
```
docker compose down
docker compose up -d
```
