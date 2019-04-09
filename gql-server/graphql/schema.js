// posts(postId: Int, title: String, text: String, views: Int): [Post]
// updateAuthor(authorId: Int, firstName: String, lastName: String, posts:[postInput]): String

//createKanji(kanji: String, strokes: Int): Kanji

const schema = `

    type Query {

        kanji(
            id: Int, 
            kanji: String, 
            strokes: Int
            reading: String
            grade: Int
            jlpt: Int
            freq: Int
            on: String
            kun: String
            ): [Kanji]
    
    }
    
    type Mutation {
    
        createKanji(kanji: String, strokes: Int): Kanji
        deleteKanji(id: Int!): Int
        
    }

    type Kanji {
        id: Int
        kanji: String
        strokes: Int
        reading: String
        grade: Int
        jlpt: Int
        freq: Int
        on: String
        kun: String
        created: String
        updated: String
    }

`;

export default schema;