FROM node:18

RUN mkdir -p /opt/app

COPY package.json /tmp/package.json

#RUN \
#    cd /tmp && \
#    npm i --production && npm update && \
#    mv node_modules /opt/app/node_modules && \
#    rm -rf /tmp/package.json /tmp/node_modules
WORKDIR /opt/app

COPY . /opt/app/

RUN npm i



EXPOSE 3001

CMD ["node", "."]
