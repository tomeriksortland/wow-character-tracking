import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import CharacterCard from "@/Components/CharacterCard.jsx";
import {useEffect, useState} from "react";
import axios from "axios";

export default function Dashboard({ auth, myCharacters, allCharactersFetched }) {

    const [allCharactersFetchedStatus, setAllCharactersFetchedStatus] = useState(allCharactersFetched)
    const [characters, setCharacters] = useState(myCharacters)

    useEffect(() => {
        const fetchAndSetCharacters = async () => {

            const response = await axios.get(`api/v1/users/${auth.user.id}/characters`)
            if (response.data.jobStatus === "completed") {
                setAllCharactersFetchedStatus(response.data.jobStatus)
                setCharacters(response.data.myCharacters);
                return Promise.resolve();
            }

            setTimeout(fetchAndSetCharacters, 2000);
        }

        if(allCharactersFetchedStatus !== 'completed') fetchAndSetCharacters()
    })

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">My characters</h2>}>
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="flex flex-wrap w-full mt-10 mx-auto justify-center">
                        {allCharactersFetchedStatus !== "completed" ? (
                            <div className="flex items-center">
                                <h1 className="text-white text-2xl">Loading characters</h1>
                                <span className="loading loading-spinner loading-lg text-info ml-4"></span>
                            </div>
                        ) : (
                         characters.map((character, index) => (
                            <div key={index} className="w-1/4 px-2 mb-2">
                                <CharacterCard
                                    character={character}
                                />
                            </div>
                        )))}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
