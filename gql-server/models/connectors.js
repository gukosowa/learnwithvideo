import rp from 'request-promise';
var Sequelize = require('sequelize');

var db = new Sequelize('learnwithvideo', 'root', '', {
  host: 'localhost',
  dialect: 'mysql',
  logging: false,

  pool: {
    max: 5,
    min: 0,
    idle: 10000
  }

});


const KanjiModel = db.define('kanji', {
    id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true, field: "id" },
    kanji: { type: Sequelize.STRING, field: "kanji", allowNull: false },
    strokes: { type: Sequelize.INTEGER, field: "strokes" },
    reading: { type: Sequelize.INTEGER, field: "reading" },
    grade: { type: Sequelize.INTEGER, field: "grade" },
    jlpt: { type: Sequelize.INTEGER, field: "jlpt" },
    freq: { type: Sequelize.INTEGER, field: "freq" },
    on: { type: Sequelize.INTEGER, field: "translation_on" },
    kun: { type: Sequelize.INTEGER, field: "translation_kun" },
    created: { type: Sequelize.INTEGER, field: "created_at" },
    updated: { type: Sequelize.INTEGER, field: "updated_at" },
    },{
        freezeTableName: false,
        timestamps: false,
        underscored: false,
        tableName: "kanji"
    });


// KanjiModel.hasMany(OtherModel, {
//     foreignKey: 'kanji_id'
// });


const Kanji = db.models.kanji;

export { Kanji };