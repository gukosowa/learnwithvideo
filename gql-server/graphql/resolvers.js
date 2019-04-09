import { Kanji } from '../models/connectors';

const resolvers = {

    kanji: function(args) { 
        return new Promise((resolve, reject) => {
            Kanji.findAll({ where: args }).then(results => {
                resolve(results);
            });
          })
    },

    createKanji: function(args) { 
        return new Promise((resolve, reject) => {
            Kanji.create(args).then(results => {
                resolve(results);
            });
          })
    },

    deleteKanji: function(args) { 
        return new Promise((resolve, reject) => {
            Kanji.destroy({ where: args }).then(results => {
                resolve(results);
            });
          })
    },
  
  };
  
  export default resolvers;