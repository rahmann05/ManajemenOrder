const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"home":{"uri":"\/","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]},"admin.dashboard":{"uri":"dashboard\/admin","methods":["GET","HEAD"]},"order.create":{"uri":"admin\/order\/create","methods":["GET","HEAD"]},"order.store":{"uri":"admin\/order","methods":["POST"]},"gudang.dashboard":{"uri":"dashboard\/gudang","methods":["GET","HEAD"]},"armada.dashboard":{"uri":"dashboard\/armada","methods":["GET","HEAD"]},"manajer.dashboard":{"uri":"dashboard\/manajer","methods":["GET","HEAD"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
