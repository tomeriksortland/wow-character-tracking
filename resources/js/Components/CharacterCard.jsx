import React from 'react';

const CharacterCard = ({character, score}) => {





    return (
        <div className="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-4">
            <div className="text-center mb-4">
                <h2 className="text-xl font-semibold text-gray-800 dark:text-gray-100 mt-2">{character.name}</h2>
                <p className="text-gray-800 dark:text-gray-100">{character.realm} - {character.region.toUpperCase()}</p>
                <div className="flex items-center justify-center h-20 w-20 bg-gray-200 dark:bg-gray-600 rounded-full mx-auto mt-3">
                    <img src={character.thumbnail} alt={character.name} className="w-16 h-16 rounded-full" />
                </div>
                <h2 className="text-xl font-semibold text-gray-800 dark:text-gray-100 mt-2">{character.spec} - {character.class}</h2>
            </div>
            <div className="flex justify-center">
                <div className="pr-2">
                    <div className="flex flex-col items-center text-center">
                        <div className="mb-2">
                            <h2 className='text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2 mr-1 inline-block'>Overall:</h2>
                            <h2 style={{ color: `${score.overall_color}` }} className={`text-xl font-semibold rounded-full inline-block`}>{score.overall}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default CharacterCard;
