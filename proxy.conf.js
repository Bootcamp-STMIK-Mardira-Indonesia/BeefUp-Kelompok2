const PROXY_CONFIG = [
    {
      context:[
        "/api"
      ],
      target: "https://documenter.getpostman.com/view/25435899/2s93CKNZgP#f90238b5-4747-4fc6-9af3-23b94d9bc29f",
      pathRewrite : {
      "^/api" : ""
      },
      changeOrigin : true,
      secure : false
    }
  ]
  module.exports = PROXY_CONFIG;