Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'contracts',
      path: '/contracts',
      component: require('./components/Tool'),
    },
  ])
})
