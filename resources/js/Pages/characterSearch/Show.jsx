import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head} from '@inertiajs/react';
import colorVariants from "@/Components/CharacterColors.jsx";
import React from "react";

export default function Index({auth, character}) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2
                className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Character</h2>}>
            <Head title="Character search"/>

            <div className="flex mt-10 bg-gray-100 dark:bg-gray-900">
                <div className="flex w-4/6 mx-auto">
                    <div className="w-full">
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6">
                            <div className="flex flex-row justify-around">
                                <div className="flex flex-col">
                                    <h2 className={`text-xl font-semibold ${colorVariants[character.class]} mt-2`}>{character.name}</h2>
                                    <p className="text-gray-800 dark:text-gray-100">{character.realm} - {character.region.toUpperCase()}</p>
                                    <div
                                        className="flex h-20 w-20 bg-gray-200 dark:bg-gray-600 rounded-full mt-3">
                                        <img src={character.thumbnail} alt={character.name}
                                             className="w-20 h-20 rounded-full"/>
                                    </div>
                                    <h2 className={`text-xl font-semibold mt-2 mb-4 ${colorVariants[character.class]}`}>{character.spec} - {character.class}</h2>
                                    <div className="flex flex-row space-x-5">
                                        <div className="mb-2">
                                            <h2 className='text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2 mr-1 inline-block'>Overall:</h2>
                                            <h2 style={{color: `${character.mythic_plus_score.overall_color}`}}
                                                className={`text-xl font-semibold rounded-full inline-block`}>{character.mythic_plus_score.overall}</h2>
                                        </div>
                                        <div className="mb-2">
                                            <h2 className='text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2 mr-1 inline-block'>Tank:</h2>
                                            <h2 style={{color: `${character.mythic_plus_score.tank_color}`}}
                                                className={`text-xl font-semibold rounded-full inline-block`}>{character.mythic_plus_score.tank}</h2>
                                        </div>
                                    </div>
                                    <div className="flex flex-row space-x-5">
                                        <div className="mb-2">
                                            <h2 className='text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2 mr-1 inline-block'>DPS:</h2>
                                            <h2 style={{color: `${character.mythic_plus_score.dps_color}`}}
                                                className={`text-xl font-semibold rounded-full inline-block`}>{character.mythic_plus_score.dps}</h2>
                                        </div>
                                        <div className="mb-2">
                                            <h2 className='text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2 mr-1 inline-block'>Healer:</h2>
                                            <h2 style={{color: `${character.mythic_plus_score.healer_color}`}}
                                                className={`text-xl font-semibold rounded-full inline-block`}>{character.mythic_plus_score.healer}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div className="flex flex-col">
                                    <div className="">
                                        <h2 className="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2 mr-1">{`+${character.mythic_plus_highest_level_runs[0].key_level} ${character.mythic_plus_highest_level_runs[0].dungeon}`}</h2>
                                    </div>
                                    <div className="flex flex-row space-x-4">
                                        <div className="flex h-12 w-12 bg-gray-200 dark:bg-gray-600 rounded-full mt-3">
                                            <img src={character.mythic_plus_highest_level_runs[0].affix_one_icon}
                                                 alt={character.mythic_plus_highest_level_runs[0].affix_one_icon}
                                                 className="w-12 h-12 rounded-full"/>
                                        </div>
                                        <div className="flex h-12 w-12 bg-gray-200 dark:bg-gray-600 rounded-full mt-3">
                                            <img src={character.mythic_plus_highest_level_runs[0].affix_two_icon}
                                                 alt={character.mythic_plus_highest_level_runs[0].affix_two_icon}
                                                 className="w-12 h-12 rounded-full"/>
                                        </div>
                                        <div className="flex h-12 w-12 bg-gray-200 dark:bg-gray-600 rounded-full mt-3">
                                            <img src={character.mythic_plus_highest_level_runs[0].affix_three_icon}
                                                 alt={character.mythic_plus_highest_level_runs[0].affix_three_icon}
                                                 className="w-12 h-12 rounded-full"/>
                                        </div>
                                    </div>
                                    <div className="flex flex-row space-x-4">
                                        <h3>{ character.mythic_plus_highest_level_runs[0].affix_one }</h3>
                                        <h3>{ character.mythic_plus_highest_level_runs[0].affix_two }</h3>
                                        <h3>{ character.mythic_plus_highest_level_runs[0].affix_three }</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
        ;
}
