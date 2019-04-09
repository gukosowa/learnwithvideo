//*#################################################
//* Welcome to Learn with Video
//*
//* by Markus Lechner 2019
//*#################################################
var express = require('express');
var express_graphql = require('express-graphql');
var { buildSchema } = require('graphql');

import schema from './graphql/schema';
import resolvers from './graphql/resolvers';
//*#################################################
//*
//*


//*#################################################
//* Create an express server and a GraphQL endpoint
var app = express();
app.use('/graphql', express_graphql({
    schema: buildSchema(schema),
    rootValue: resolvers,
    graphiql: true
}));
app.listen(4000, () => console.log('Express GraphQL Server Now Running On localhost:4000/graphql'));