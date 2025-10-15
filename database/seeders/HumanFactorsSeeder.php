<?php

//REALIZZATO DA: Andrea Amodeo

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HumanFactor;
use Illuminate\Support\Str;

class HumanFactorsSeeder extends Seeder
{
    public function run()
    {
         $items = [
            ['name' => 'Age (demographic factor)', 'description' => ''],
            ['name' => 'Gender (demographic factor)', 'description' => ''],
            ['name' => 'Education Level', 'description' => 'Demographic factor that refers to the highest degree of school completed by an individual.'],
            ['name' => 'Agreeableness', 'description' => 'Personality trait of the Big Five scale. Individuals with high agreableness tend to be more altruistic, cooperative and sympathetic to cope with social situations.'],
            ['name' => 'Extroversion', 'description' => 'Extroversion (or Extraversion) is characterized by flamboyance, talkativeness, assertiveness, and high degrees of emotional expression.'],
            ['name' => 'Conscientiousness', 'description' => 'Personality trait of the Big Five scale. People with high conscientiousness are very thoughtful, self-disciplined and able to control their impulses to pursue their goals.'],
            ['name' => 'Neuroticism', 'description' => 'Personality trait of the Big Five scale. People with high levels of neuroticism tend to experience mood swings, anxiety, irritability, and sadness.'],
            ['name' => 'Vigilance', 'description' => 'The state of alertness and attentiveness to potential risks or changes in the environment.'],
            ['name' => 'Misperception', 'description' => 'Wrong or inaccurate understanding interpretation based on observation of facts and reality'],
            ['name' => 'Uncertainty', 'description' => 'The lack of sureness about someone or something. It should be related to all events that occur in some degree of uncertainty.'],
            ['name' => 'Overconfidence', 'description' => 'Cognitive bias that leads people to overestimate their abilities compared to others.'],
            ['name' => 'Perfectionism', 'description' => 'Strong desire to minimize or avoid mistakes and to ensure that everything is performed as accurately as possible.'],
            ['name' => 'Negativity bias', 'description' => 'Causes people to focus more on negative information than on positive information.'],
            ['name' => 'Rank Effect', 'description' => 'It is a behavioural bias that occurs when people judge information based on relative measures instead of using natural benchmarks.'],
            ['name' => 'Anchoring bias', 'description' => 'It occurs when individuals use initial information to make subsequent judgments.'],
            ['name' => 'Limited attention /Focus', 'description' => 'It is the inability for a person to attend to or analyse all of the information available to him or her.'],
            ['name' => 'Perception of small probabilities', 'description' => 'It is a cognitive bias in which individuals give too much weight to small probabilites and not enough to moderate probabilities.'],
            ['name' => 'Preference for the present', 'description' => 'It is a cognitive bias that leads to overcompensation of the present with respect to the future. Decision-makers overvalue corretness of current choices than prepare a future defence.'],
            ['name' => 'Lack of Awareness', 'description' => 'Not being aware of what happens in the surrounding working or online environment, often leading to an unconscious disconnection from what others are doing'],
            ['name' => 'Imitation', 'description' => 'The action of using something or someone as a model.'],
            ['name' => 'Asymmetric Information', 'description' => 'The differences in the knowledge of the risks, conditions, and facts that people have access to when making decisions in an environment.'],
            ['name' => 'Trust Propensity', 'description' => 'The psychological tendency of an individual to trust others in general. In particular, it measures a person\'s willingness to depend on others.'],
            ['name' => 'Trust and Risk Perception', 'description' => 'In general, the greater the trust in, for example, a service provider, the lower the perceived risk, and vice versa.'],
            ['name' => 'Authority', 'description' => 'Bias connected to the mandate to influence others due to individual elemental status'],
            ['name' => 'Consistency', 'description' => 'It is a persuasion principle that assumes individuals\' efforts to be consistent in what they say and do.'],
            ['name' => 'Liking', 'description' => 'It is the principle that individuals are more influenced by people they like, understand and who understand them.'],
            ['name' => 'Scarcity', 'description' => 'The principle assumes that when a resource is scarce, we assume that it is valuable and we are more led to grab it.'],
            ['name' => 'Sensitivity', 'description' => 'The capacity to understand and convey emotional conditions with empathy.'],
            ['name' => 'Induction/suggestion', 'description' => 'The process of leading a person to think, feel and act differently through suggestion.'],
            ['name' => 'Insight/Lack of awareness', 'description' => 'The awareness that we have regarding ourselves and the external world.'],
            ['name' => 'Persistence', 'description' => 'Act of doing something continuously or repeatedly despite problems or difficulties.'],
            ['name' => 'General Ability', 'description' => 'The factor used to make predictions about an individual\'s possible achievements. In the personality domain, it refers to the ability used correctly,a necessary variable for evaluating psychological tools'],
            ['name' => 'Impulsivity', 'description' => 'The tendency to act and react by ignoring the consequences of one\'s actions and reactions.'],
            ['name' => 'Distractibility', 'description' => 'The tendency to get easily distracted.'],
            ['name' => 'Social Desirability', 'description' => 'The tendency of individuals to endorse a more or less deliberately presented image of themselves to others'],
            ['name' => 'Resistance', 'description' => 'The tendency to resist external inputs to produce contrary positions.'],
            ['name' => 'Self-efficacy', 'description' => 'The individual\'s belief in relating to his or her ability to plan and complete activities.'],
            ['name' => 'Self-esteem', 'description' => 'It is the product of the complex interaction between the cognitive activity of holistic evaluation that the subject makes of himself/herself and the various experiences that s/he has.'],
            ['name' => 'Empathy', 'description' => 'The ability to fully understand the position of others, by removing their own condition.'],
            ['name' => 'Passive Aggressiveness', 'description' => 'The tendency to indirectly express aggression towards others.'],
            ['name' => 'Inadequacy', 'description' => 'The inadequacy of a certain cognitive, behavioral or emotional process.'],
            ['name' => 'Pseudo Omnipotence', 'description' => 'When people overestimate their own abilities, do not know how to set limitations, and don\'t seek information. It is common in adolescents.'],
            ['name' => 'Invasion', 'description' => 'It relates to the SAE conflict management style. It occurs when we impose our point of view at the expense of others.'],
            ['name' => 'Behaviour Style (Conflict)', 'description' => 'The styles used to manage conflict affect decision-making.'],
            ['name' => 'Detachment', 'description' => 'It relates to the SAE conflict management style. It occurs when we detach ourselves from the other and use emotional abandonment of the conflict.'],
            ['name' => 'Emotional Sensitivity', 'description' => 'The higher the emotional sensitivity, the higher the probability that the person will experience feelings of discomfort.'],
            ['name' => 'Abandonment and Helplessness', 'description' => 'Lifelong feeling that the person cannot rely on others for help, support, protection, and care.'],
            ['name' => 'Emotional inhibition', 'description' => 'It is characterized by a deficit of self-confidence and a continuous avoidance of expressing one\'s feelings.'],
            ['name' => 'Mental Ruminations (Overthinking)', 'description' => 'Tendency to obsessively mull over one\'s emotions without acting on them.'],
            ['name' => 'Concern with Envy or Shame', 'description' => 'Tendency to hide their achievements from fear of arousing envy in others.'],
        ];

        foreach ($items as $it) {
            HumanFactor::updateOrCreate(
                ['slug' => Str::slug($it['name'])],
                ['name' => $it['name'], 'description' => $it['description']]
            );
        }
    }
}
